<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;

class HospitalReportController extends Controller
{
    public function index(Request $request)
    {
        // Loads the same Blade you’re already on OR a separate /reports page.
        // If you prefer keeping it on the current page, just add the modal there (see Blade below).
        return view('admin.hospitals.reports'); 
    }

    private function baseQuery(Request $request)
    {
        $q = Hospital::query()
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count'), '<=', DB::raw('hb.qty_of_env'));
            });

        // Filters (extend as needed)
        if ($state = $request->get('state')) {
            $q->where('hospitals.state', $state);
        }
        if ($name = $request->get('name')) {
            $q->where('hospitals.organization_name', 'like', "%{$name}%");
        }
        if ($minEnv = $request->get('min_valentine_cards')) {
            $q->where('hospitals.valentine_card_count', '>=', (int)$minEnv);
        }
        if ($maxEnv = $request->get('max_valentine_cards')) {
            $q->where('hospitals.valentine_card_count', '<=', (int)$maxEnv);
        }
        if ($standing = $request->get('standing_order')) {
            $q->where('hospitals.standing_order', $standing === 'yes');
        }

        return $q->orderBy('reference');
    }

    // DataTables JSON (server-side)
    public function data(Request $request)
    {
        try {
            $rows = $this->baseQuery($request)
                // ->with('volunteer')
                ->select([
                    'hospitals.id','hospitals.organization_name','hospitals.contact_person_name','hospitals.how_to_address',
                    'hospitals.email','hospitals.phone','hospitals.street','hospitals.city','hospitals.state','hospitals.zip',
                    'hospitals.valentine_card_count','hospitals.extra_staff_cards','hospitals.prefilled_link','hospitals.standing_order','hospitals.update_status','hospitals.updated_at',
                    'hospitals.public_notes','hospitals.internal_notes','hospitals.contact_title',
                    'hb.box_style','hb.length','hb.width','hb.height','hb.empty_weight','hb.full_weight',
                    // 'v.name as volunteer_name','v.phone as volunteer_phone',
                    DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                    DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                ])->get();
    
            return response()->json(['data' => $rows]);
        } catch (\Throwable $e) {
            logger()->error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }        
    }

    // Exports share filters via query string (?state=CA&min_valentine_cards=100...)
    public function export(Request $request, string $type)
    {
        $rows = $this->baseQuery($request)
            // ->with('volunteer')
            ->select([
                'hospitals.id','hospitals.organization_name','hospitals.contact_person_name','hospitals.how_to_address',
                'hospitals.email','hospitals.phone','hospitals.street','hospitals.city','hospitals.state','hospitals.zip',
                'hospitals.valentine_card_count','hospitals.extra_staff_cards','hospitals.prefilled_link','hospitals.standing_order','hospitals.update_status','hospitals.updated_at',
                'hospitals.public_notes','hospitals.internal_notes','hospitals.contact_title',
                'hb.box_style','hb.length','hb.width','hb.height','hb.empty_weight','hb.full_weight',
                // 'v.name as volunteer_name','v.phone as volunteer_phone',
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
            ])->get();

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.hospitals.report-pdf', ['rows' => $rows, 'filters' => $request->all()])
                    ->setPaper('a4', 'landscape'); // or 'letter';
            return $pdf->download('hospitals-report(' . now()->format('Y-m-d') . ').pdf');
        }

        // CSV / XLSX
        $export = new class($rows) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function __construct(private $rows) {}
            public function array(): array {
                return $this->rows->map(function ($r) {
                    return [
                        $r->reference,
                        $r->organization_name,
                        $r->contact_person_name,
                        $r->email,
                        $r->phone,
                        $r->street, $r->city, $r->state, $r->zip,
                        $r->valentine_card_count,
                        $r->extra_staff_cards,
                        ($r->valentine_card_count + $r->extra_staff_cards),
                        $r->box_style,
                        "{$r->length}x{$r->width}x{$r->height}",
                        $r->empty_weight,
                        $r->full_weight,
                        $r->prefilled_link,
                        $r->public_notes,
                        $r->internal_notes,
                        $r->updated_at->format('M d, Y')
                        // $r->prefilled_link,
                        // $r->standing_order ? 'Yes' : 'No',
                        // $r->update_status ? 'Updated' : '—',
                    ];
                })->toArray();
            }
            public function headings(): array {
                return [
                    'ID','Organization','Contact','Email','Phone',
                    'Street','City','State','ZIP',
                    'Valentine Cards','Staff Cards','Total Cards','Box Style','Dimensions','Empty Box','Full Weight',
                    'Prefilled Link','Notes from Hosp/Organization','Internal Notes','Last Updated'
                ];
            }
        };

        $filename = 'hospitals-report(' . now()->format('Y-m-d') . ').' . ($type === 'xlsx' ? 'xlsx' : 'csv');
        $writer = $type === 'xlsx' ? ExcelWriter::XLSX : ExcelWriter::CSV;

        return Excel::download($export, $filename, $writer);
    }

    // OPTIONAL: export to Google Sheets
    public function exportToSheets(Request $request)
    {
        // You’ll need a service account JSON and a shared Sheet.
        // 1) Create a Google Cloud project, enable Sheets API
        // 2) Create service account & JSON key, store path in config/env
        // 3) Share target sheet with service account email
        // This is a minimal example; handle auth/config as you prefer.

        $rows = $this->baseQuery($request)
            // ->with('volunteer')
            ->select([
                'hospitals.id','hospitals.organization_name','hospitals.contact_person_name','hospitals.how_to_address',
                'hospitals.email','hospitals.phone','hospitals.street','hospitals.city','hospitals.state','hospitals.zip',
                'hospitals.valentine_card_count','hospitals.extra_staff_cards','hospitals.prefilled_link','hospitals.standing_order','hospitals.update_status','hospitals.updated_at',
                'hospitals.public_notes','hospitals.internal_notes','hospitals.contact_title',
                'hb.box_style','hb.length','hb.width','hb.height','hb.empty_weight','hb.full_weight',
                // 'v.name as volunteer_name','v.phone as volunteer_phone',
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
            ])->get();

        $client = new \Google\Client();
        $client->setApplicationName('Hospital Reports');
        $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $client->setAuthConfig(storage_path('app/google/service-account.json')); // adjust path
        $service = new \Google\Service\Sheets($client);

        $spreadsheetId = config('services.google.sheets_id'); // put in config/services.php & .env
        $range = 'Sheet1!A1'; // top-left cell

        $values = [];
        $values[] = [
            'ID','Organization','Contact','Email','Phone',
            'Street','City','State','ZIP',
            'Valentine Cards','Staff Cards','Total Cards','Box Style','Dimensions','Empty B','Full_weight',
            'Prefilled Link','Notes from Hosp/Organization','Internal Notes','Last Updated'
        ];
        foreach ($rows as $r) {
            $values[] = [
                $r->reference,
                $r->organization_name,
                $r->contact_person_name,
                $r->email,
                $r->phone,
                $r->street, $r->city, $r->state, $r->zip,
                $r->valentine_card_count,
                $r->extra_staff_cards,
                ($r->valentine_card_count + $r->extra_staff_cards),
                $r->box_style,
                "{$r->length}x{$r->width}x{$r->height}",
                $r->empty_weight,
                $r->full_weight,
                $r->prefilled_link,
                $r->public_notes,
                $r->internal_notes,
                $r->updated_at->format('M d, Y')
                // $r->prefilled_link,
                // $r->standing_order ? 'Yes' : 'No',
                // $r->update_status ? 'Updated' : '—',
            ];
        }

        $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];

        // Clear & write
        $service->spreadsheets_values->clear($spreadsheetId, 'Sheet1', new \Google\Service\Sheets\ClearValuesRequest());
        $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

        return back()->with('status', 'Exported to Google Sheets!');
    }
}
