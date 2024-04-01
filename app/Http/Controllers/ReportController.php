<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use App\Models\Region;
use App\Models\Report;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function index()
    {
        $userSession = Session::get('userSession');
        $dataReport = Report::join('users', 'reports.reporter', '=', 'users.id')
            ->join('master_data as md', 'reports.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->select('reports.id', 'reporting_date', 'reports.jumlah', 'md.no_article', 'md.description', 'mg.name as mgname', 'uoms.name as uomname', 'users.username')
            ->where('users.username', $userSession->username)
            ->paginate(25);
        $stationUser = Station::where('id', $userSession->station_id)->first();
        $regionUser = Region::where('id', $userSession->region_id)->first();
        $md = MasterData::select('id', 'no_article', 'description')->get();
        return view('content.report.list', compact('dataReport', 'md', 'stationUser', 'regionUser'))
            ->with('i');

    }

    public function processAdd(Request $request)
    {
        $request->validate(
            [
                'item' => 'required',
                'jumlah' => 'required|integer',
            ],
            [
                'item.required' => 'pilih item terlebih dahulu',
                'jumlah.required' => 'masukan jumlah',
                'jumlah.integer' => 'jumlah wajib angka',
            ]
        );
        $userSession = Session::get('userSession');

        $currentDate = Carbon::now();
        $currentYear = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate)->year;
        try {
            $existingItem = Report::where('master_data', $request->input('item'))
            ->where('reporting_date', $currentDate->toDateString())
            ->first();
           
            if ($existingItem) {
                // Jika sudah ada, update jumlahnya
                $existingItem->jumlah += $request->input('jumlah');
                $existingItem->save();
                return redirect()->route('get-list-report')->with('success', 'Jumlah item berhasil diperbarui.');
            }

            $item = new Report([
                'master_data' => $request->input('item'),
                'reporter' =>$userSession->id,
                'reporting_date' => $currentDate->toDateString(),
                'reporting_year' => $currentYear,
                'jumlah' => $request->input('jumlah'),
            ]);
            $item->save();
            return redirect()->route('get-list-report')->with('success', 'Berhasil Menambah item baru');

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('get-list-report')->with('error', 'terjadi kesalahan');
        }

    }
}
