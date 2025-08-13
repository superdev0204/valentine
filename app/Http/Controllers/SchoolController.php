<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolBoxSizeMatrix;
use App\Models\School;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    // Schools methods
    public function schoolList()
    {
        $schools = School::select('schools.*', 'sb.id as matrix_id', 'sb.box_style', 'sb.length', 'sb.width', 'sb.height', 'sb.empty_box', 'sb.weight')
            ->leftJoin('school_box_size_matrices as sb', function ($join) {
                $join->on(DB::raw('schools.envelope_quantity'), '>', DB::raw('sb.greater_than'))
                    ->on(DB::raw('schools.envelope_quantity'), '<=', DB::raw('sb.qty_of_env'));
            })
            ->orderBy('schools.id')
            ->get();

        return view('admin.schools.index', compact('schools'));
    }

    public function createSchool()
    {
        return view('admin.schools.create');
    }

    public function storeSchool(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'envelope_quantity' => 'required|integer|min:0',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'standing_order' => 'boolean',
            'prefilled_link' => 'nullable|string',
        ]);

        School::create($request->all());
        return redirect()->route('admin.schools')->with('success', 'School created successfully.');
    }

    public function editSchool(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function updateSchool(Request $request, School $school)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'envelope_quantity' => 'required|integer|min:0',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'standing_order' => 'boolean',
            'prefilled_link' => 'nullable|string',
        ]);

        $school->update($request->all());
        return redirect()->route('admin.schools')->with('success', 'School updated successfully.');
    }

    public function deleteSchool(School $school)
    {
        $school->delete();
        return redirect()->route('admin.schools')->with('success', 'School deleted successfully.');
    }

    public function importSchools(Request $request)
    {
        try {
            $spreadsheetId = env('GOOGLE_SHEETS_SCHOOL_ID', '1u0DFmacIwOlkbuhD1Um809-Mzif2JQpepnJ5WDn66W4');
            
            // Try to access the sheet as a public CSV export
            $csvUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid=1903950335";
            
            $response = Http::get($csvUrl);
            
            if (!$response->successful()) {
                throw new \Exception('Failed to access Google Sheet. Make sure it is shared publicly or with the service account.');
            }
            
            $csvData = $response->body();
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            
            // Remove empty rows
            $rows = array_filter($rows, function($row) {
                return !empty(array_filter($row));
            });
            
            if (empty($rows) || count($rows) < 3) {
                return redirect()->route('admin.schools')->with('error', 'No data found in the Google Sheet. Need at least 3 rows (first row + header row + data row).');
            }

            // Skip first row and use second row as header
            array_shift($rows); // Remove first row
            $header = array_map('trim', array_shift($rows)); // Use second row as header
            
            // Now $rows contains only data rows (starting from third row)
            $imported = 0;

            foreach ($rows as $row) {
                // Pad the row to match header length
                $paddedRow = array_pad($row, count($header), '');
                $data = array_combine($header, $paddedRow);

                $schoolData = [
                    'participation' => $data["Will you participate to create wonderful Valentine's Day cards?"] ?? '',
                    'organization_name' => $data["Name of School or Organization"] ?? '',
                    'contact_person_name' => $data["Contact Person's Name"] ?? '',
                    'email' => $data["Email Address"] ?? '',
                    'how_to_address' => $data['How to address you (like "Ms. Jones")'] ?? '',
                    'envelope_quantity' => intval($data["Quantity of empty Valentine's envelopes we should send to you.  (Please estimate realistically - We promise hospitals quantities based upon the number of envelopes you request and, if you return fewer, we can't fulfill the promise - Thank you!)"] ?? 0),
                    'instructions_cards' => intval($data["Each teacher will receive an instructions card.  How many instructions cards shall we include?"] ?? 0),
                    'street' => $data["Street Address for delivery of envelopes to you: (without city/state -- just the street address)"] ?? '',
                    'city' => $data['City'] ?? '',
                    'state' => $data['State/District'] ?? '',
                    'zip' => $data['Zip Code'] ?? '',
                    'phone' => $data["Phone (Fedex requires in case they have an issue - enter digits only, no spaces, dashes, or parentheses):"] ?? '',
                    'standing_order' => ($data["Do you want to make this a standing order (we just send you the same amount in future years), so you don't have to remember (makes it easier for you and for us)?"] == "Yes" ? 1 : 0),
                    'question' => $data["Any other questions or thoughts to share?"] ?? null,
                    'introducer' => $data["How did you find out about Valentines By Kids?"] ?? null,
                    'prefilled_link' => $data["Prefilled Link"] ?? null,
                    'update_status' => 0,
                ];

                if (!empty($schoolData['email'])) {
                    \App\Models\School::updateOrCreate(
                        ['organization_name' => $schoolData['organization_name'], 'email' => $schoolData['email']],
                        $schoolData
                    );
                    $imported++;
                }
            }

            return redirect()->route('admin.schools')->with('success', "Successfully connected to Google Sheets. Found " . count($rows) . " data rows (using second row as header).");

        } catch (\Exception $e) {
            return redirect()->route('admin.schools')->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
}