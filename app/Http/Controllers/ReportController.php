<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use App\Models\Region;
use App\Models\Report;
use App\Models\Station;
use App\Models\Stock;
use App\Models\TStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function index()
    {
        $userSession = Session::get('userSession');
        $stationUser = $userSession->station_id;
        $regionUser = $userSession->region_id;
        $dataReport = Report::join('users', 'reports.reporter', '=', 'users.id')
            ->join('master_data as md', 'reports.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->select('reports.id', 'reporting_date', 'reports.jumlah', 'md.no_article', 'md.description', 'mg.name as mgname', 'uoms.name as uomname', 'users.username')
            ->where('users.username', $userSession->username)
            ->paginate(25);

        $md = MasterData::select('id', 'no_article', 'description')->get();
        return view('content.report.list', compact('dataReport', 'md', 'stationUser', 'regionUser'))
            ->with('i');

    }

    public function showReportAdmin()
    {
        $userSession = Session::get('userSession');
        $showDataReport = Report::join('users', 'reports.reporter', '=', 'users.id')
            ->join('master_data as md', 'reports.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->selectRaw('md.id as master_data_id,md.no_article, md.description, mg.name as mgname,reports.reporting_date, uoms.name as uomname, SUM(reports.jumlah) as total_jumlah')
            ->groupBy('md.id', 'reports.reporting_date')
            ->paginate(25);

        return view('content.report.admin', compact('showDataReport'))
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

            $existingStock = Stock::where('master_data', $request->input('item'))->first();

            $isAdmin = $userSession->role;
            if ($isAdmin == 'superadmin') {
                return redirect()->route('login')->with('error', 'admin tidak boleh membuat report.');
            }
            if ($existingStock) {

                $existingTStock = TStock::where('item_id', $existingStock->id)
                    ->where('tanggal', $currentDate->toDateString())
                    ->first();
                if ($existingTStock) {

                    $existingItem = Report::where('master_data', $request->input('item'))
                        ->where('reporting_date', $currentDate->toDateString())
                        ->where('reporter', $userSession->id)
                        ->first();
                    if ($existingItem) {
                        DB::beginTransaction();

                        $existingStock->stock += $request->input('jumlah');
                        $existingTStock->stock += $request->input('jumlah');
                        $existingItem->jumlah += $request->input('jumlah');
                        $existingStock->save();
                        $existingTStock->save();
                        $existingItem->save();
                        DB::commit();

                        return redirect()->route('get-list-report')->with('success', 'Jumlah item berhasil diperbarui.');
                    }
                    DB::beginTransaction();

                    $item = new Report([
                        'master_data' => $request->input('item'),
                        'reporter' => $userSession->id,
                        'reporting_date' => $currentDate->toDateString(),
                        'reporting_year' => $currentYear,
                        'jumlah' => $request->input('jumlah'),
                    ]);
                    $existingStock->stock += $request->input('jumlah');
                    $existingStock->save();
                    $existingTStock->stock += $request->input('jumlah');
                    $existingTStock->save();
                    $item->save();
                    DB::commit();
                    return redirect()->route('get-list-report')->with('success', 'Jumlah item berhasil diperbarui.');


                }
                DB::beginTransaction();

                $tstock = new TStock([
                    'item_id' => $existingStock->id,
                    'tanggal' => $currentDate->toDateString(),
                    'stock' => $request->input('jumlah'),
                ]);
                $item = new Report([
                    'master_data' => $request->input('item'),
                    'reporter' => $userSession->id,
                    'reporting_date' => $currentDate->toDateString(),
                    'reporting_year' => $currentYear,
                    'jumlah' => $request->input('jumlah'),
                ]);
                $existingStock->stock += $request->input('jumlah');
                $existingStock->save();
                $tstock->save();
                $item->save();
                DB::commit();

                return redirect()->route('get-list-report')->with('success', 'Berhasil merubah stock');
            }
            DB::beginTransaction();

            $stock = new Stock([
                'master_data' => $request->input('item'),
                'stock' => $request->input('jumlah'),
            ]);
            $stock->save();
            $tstock = new TStock([
                'item_id' => $stock->id,
                'tanggal' => $currentDate->toDateString(),
                'stock' => $request->input('jumlah'),
            ]);
            $item = new Report([
                'master_data' => $request->input('item'),
                'reporter' => $userSession->id,
                'reporting_date' => $currentDate->toDateString(),
                'reporting_year' => $currentYear,
                'jumlah' => $request->input('jumlah'),
            ]);
            $tstock->save();
            $item->save();
            DB::commit();

            return redirect()->route('get-list-report')->with('success', 'Berhasil Merubah stock');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->route('get-list-report')->with('error', 'terjadi kesalahan');
        }

    }
}
