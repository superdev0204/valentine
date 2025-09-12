<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HospitalBoxSizeMatrix;
use App\Models\Hospital;
use App\Models\HospitalOutgoingFedexFieldMapping;
use App\Models\HospitalSendgridFieldMapping;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospitalController extends Controller
{
    // Hospitals methods
    public function hospitalList()
    {
        $hospitals = Hospital::select('hospitals.*', 
                DB::raw('(hospitals.valentine_card_count + hospitals.extra_staff_cards) as totalHospRequested'), 
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                'hb.id as matrix_id', 
                'hb.box_style', 
                'hb.length', 
                'hb.width', 
                'hb.height', 
                'hb.empty_box', 
                'hb.weight')
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '<=', DB::raw('hb.qty_of_env'));
            })
            ->orderBy('reference')
            ->get();

        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function createHospital()
    {
        return view('admin.hospitals.create');
    }

    public function storeHospital(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'valentine_card_count' => 'required|integer|min:0',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'standing_order' => 'boolean',
            // 'prefilled_link' => 'nullable|string',
        ]);

        $hospital = Hospital::create($request->all());        
        $hospital->update([
            'prefilled_link' => url('/hospital/' . $hospital->id . '/edit')
        ]);

        return redirect()->route('admin.hospitals')->with('success', 'Hospital created successfully.');
    }

    public function editHospital(Hospital $hospital)
    {
        return view('admin.hospitals.edit', compact('hospital'));
    }

    public function updateHospital(Request $request, Hospital $hospital)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'valentine_card_count' => 'required|integer|min:0',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'standing_order' => 'boolean',
            // 'prefilled_link' => 'nullable|string',
        ]);

        $hospital->update($request->all());
        $hospital->prefilled_link = url('/hospital/' . $hospital->id . '/edit');
        $hospital->save();

        return redirect()->route('admin.hospitals')->with('success', 'Hospital updated successfully.');
    }

    public function deleteHospital(Hospital $hospital)
    {
        $hospital->delete();
        return redirect()->route('admin.hospitals')->with('success', 'Hospital deleted successfully.');
    }

    public function importHospitals(Request $request)
    {
        try {
            $spreadsheetId = env('GOOGLE_SHEETS_HOSPITAL_ID', '1NJuNcffKR2KeJLkFSsCyICdUhKXCwNV8');
            
            // Try to access the sheet as a public CSV export
            $csvUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid=616306137";
            
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
                return redirect()->route('admin.hospitals')->with('error', 'No data found in the Google Sheet. Need at least 3 rows (first row + header row + data row).');
            }

            // Skip first row and use second row as header
            // array_shift($rows); // Remove first row
            $header = array_map('trim', array_shift($rows)); // Use second row as header

            for ($i = 0; $i < 2; $i++) {
                array_shift($rows);
            }
            
            // Now $rows contains only data rows (starting from third row)
            $imported = 0;

            foreach ($rows as $row) {
                // Pad the row to match header length
                $paddedRow = array_pad($row, count($header), '');
                $data = array_combine($header, $paddedRow);
                $hospitalData = [
                    'valentine_opt_in' => $data["May I send you some Valentine's Day cards?"] ?? '',
                    'organization_name' => $data["Name of Organization"] ?? '',
                    'organization_type' => $data["Type of Organization"] ?? '',
                    'contact_person_name' => $data["Contact Person's Name"] ?? '',
                    'email' => $data["Email Address"] ?? '',
                    'how_to_address' => $data['How to address you (like "Ms. Anderson")'] ?? '',
                    'valentine_card_count' => intval($data["Number of Valentine's Day Cards Desired for your patients/clients?"] ?? 0),
                    'extra_staff_cards' => intval($data["If we have enough cards, how many extra cards would you like for your wonderful staff?"] ?? 0),
                    'street' => $data["Street address for delivery to you (no city, state, zip here)"] ?? '',
                    'city' => $data["City"] ?? '',
                    'state' => strtoupper($data["State/District:"]) ?? '',
                    'zip' => $data["Zip Code:"] ?? '',
                    'phone' => $data["Phone (Fedex requires in case they have an issue - enter 10 digits only - no dashes, no hyphens, spaces, or parentheses):"] ?? '',
                    'standing_order' => ($data["Do you want to make this a standing order (we send you the same amount each year) so you don't need to worry about remembering? (Easier for us and for you!)"] == "Yes" ? 1 : 0),
                    'question' => $data["Any other questions or comments?"] ?? null,
                    'introducer' => $data["How did you hear about Valentine's By Kids?"] ?? null,
                    'prefilled_link' => $data["Prefilled Link"] ?? null,
                    'update_status' => 0,
                ];

                if (!empty($hospitalData['email'])) {
                    $hospital = \App\Models\Hospital::updateOrCreate(
                        [
                            'organization_name' => $hospitalData['organization_name'],
                            'email' => $hospitalData['email']
                        ],
                        $hospitalData
                    );

                    $hospital->prefilled_link = url('/hospital/' . $hospital->id . '/edit');
                    $hospital->save();
                
                    $imported++;
                }
            }

            return redirect()->route('admin.hospitals')->with('success', "Imported $imported hospitals from Google Sheets.");

        } catch (\Exception $e) {
            return redirect()->route('admin.hospitals')->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }

    public function exportSendgridCsv(Request $request)
    {
        $query = Hospital::select('hospitals.*', 
                DB::raw('(hospitals.valentine_card_count + hospitals.extra_staff_cards) as totalHospRequested'), 
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                'hb.id as matrix_id', 
                'hb.box_style', 
                'hb.length', 
                'hb.width', 
                'hb.height', 
                'hb.empty_box', 
                'hb.weight')
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '<=', DB::raw('hb.qty_of_env'));
            })
            // ->where('hospitals.update_status', 1)
            ->orderBy('reference');

        if ($request->scope === 'since' && $request->has('since')) {
            $sinceDate = Carbon::parse($request->since)->startOfDay();
            $query->where('hospitals.updated_at', '>=', $sinceDate);
        }

        $hospitals = $query->get();

        $fileName = 'Hospital Sendgrid Upload Format.csv';

        $mappings = HospitalSendgridFieldMapping::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('sendgrid_field')->toArray();

        $callback = function() use ($hospitals, $mappings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            foreach ($hospitals as $hospital) {
                $row = [];
        
                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        // Pull value from the hospitals table dynamically
                        $row[] = $hospital->{$map->our_field} ?? '';
                    } elseif (!empty($map->common_value)) {
                        // Use the static/common value
                        $row[] = $map->common_value;
                    } else {
                        // Leave blank if neither
                        $row[] = '';
                    }
                }
        
                fputcsv($file, $row);
            }
        
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportFedexCsv(Request $request)
    {
        $fileName = 'Fedex Formatted hospitals Import '. now()->format('m-d-Y') .'.csv';
        $query = Hospital::select('hospitals.*', 
                DB::raw('(hospitals.valentine_card_count + hospitals.extra_staff_cards) as totalHospRequested'), 
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                'hb.id as matrix_id', 
                'hb.box_style', 
                'hb.length', 
                'hb.width', 
                'hb.height', 
                'hb.empty_box', 
                'hb.weight')
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '<=', DB::raw('hb.qty_of_env'));
            })
            // ->where('hospitals.update_status', 1)
            ->orderBy('reference');

        if ($request->scope === 'since' && $request->has('since')) {
            $sinceDate = Carbon::parse($request->since)->startOfDay();
            $query->where('hospitals.updated_at', '>=', $sinceDate);
        }

        $hospitals = $query->get();

        $mappings = HospitalOutgoingFedexFieldMapping::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('fedex_field')->toArray();

        $callback = function() use ($hospitals, $mappings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            foreach ($hospitals as $hospital) {
                $row = [];
        
                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        // Pull value from the hospitals table dynamically
                        $row[] = $hospital->{$map->our_field} ?? '';
                    } elseif (!empty($map->common_value)) {
                        // Use the static/common value
                        $row[] = $map->common_value;
                    } else {
                        // Leave blank if neither
                        $row[] = '';
                    }
                }
        
                fputcsv($file, $row);
            }
        
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}