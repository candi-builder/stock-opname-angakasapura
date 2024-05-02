<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyExport;
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
use Maatwebsite\Excel\Facades\Excel;

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
            ->selectRaw('md.id as master_data_id, md.no_article, md.description,users.username, mg.name as mgname,reports.reporting_date, uoms.name as uomname, reports.jumlah')
            ->paginate(25);

        return view('content.report.admin', compact('showDataReport'))
            ->with('i');

    }

    public function showStockPerItem(){
        $shosStockPerItem = Stock::join('master_data','stocks.master_data','=','master_data.id')
        ->join('material_groups as mg','master_data.material_group','=','mg.id')
        ->join('uoms','master_data.uom','=','uoms.id')
        ->select('master_data.description','master_data.no_article','uoms.name as uom','mg.name as material_group','stocks.stock')
        ->paginate(25);
        return view('content.stock.peritem', compact('shosStockPerItem'))
        ->with('i');
    }
    public function showHistoriStockToday()
    {
        $userSession = Session::get('userSession');
        $totalStock = Stock::join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
        ->where('tanggal', '=', $userSession->today)
        ->sum('tstock.stock');
        $showDataStock = Stock::join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
            ->join('master_data as md', 'stocks.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->where('tanggal', '=', $userSession->today)
            ->select('stocks.*','tstock.stock as qty', 'md.no_article', 'md.description', 'mg.name as mgname', 'uoms.name as uomname', 'tstock.tanggal','md.id as mdid')
            ->paginate(25)
        ;
        return view('content.stock.today', compact('showDataStock','totalStock'))
            ->with('i');
        ;
    }

    public function showHistoriStockMonthly()
    {
        $currentDate = Carbon::now();
        $dateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate);
        if (!Session::has('monthlyHistory')) {
            Session::put('monthlyHistory', $dateFormat->month);
            Session::put('annualHistory', $dateFormat->year);
        }
        $month = Session::get('monthlyHistory');
        $year = Session::get('annualHistory');
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $totalStock = Stock::join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
        ->whereMonth('tanggal', '=', $month)
        ->whereYear('tanggal', '=', $year)
        ->sum('tstock.stock');
        $showDataStock = Stock::join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
            ->join('master_data as md', 'stocks.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->whereMonth('tanggal', '=', $month)
            ->whereYear('tanggal', '=', $year)
            ->select('stocks.*','tstock.stock as qty', 'md.no_article', 'md.description', 'mg.name as mgname','md.id as mdid', 'uoms.name as uomname', 'tstock.tanggal')
            ->paginate(25)
        ;
        return view('content.stock.monthly', compact('showDataStock', 'bulan', 'year','totalStock'))
            ->with('i');

    }

    public function monthlyExportExcel(){
        return Excel::download(new MonthlyExport,'monthly.xlsx');
    }

    public function filterData(Request $request)
    {
        $request->validate(
            [
                'month' => 'required',
                'year' => 'required',
            ],
            [
                'month' => 'pilih bulan sebelum mem filter',
                'year' => 'pilih  tahun mem filter',
            ]
        );
        $month = $request->input('month');
        $year = $request->input('year');
        if ($request->has('month') && $request->has('year') && $month != 0) {
            $month = $request->input('month');
            $year = $request->input('year');
            Session::put('annualHistory', $year);
            Session::put('monthlyHistory', $month);
            return redirect()->route('stock-monthly');
        }
            $year = $request->input('year');
            Session::put('annualHistory', $year);
            return redirect()->route('stock-annual');
    }
    public function showHistoriStockAnnual()
    {
        $currentDate = Carbon::now();
        $dateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate);
        if (Session::has('annualHistory')) {
            Session::put('monthlyHistory', $dateFormat->month);
        }

        $year = Session::get('annualHistory');
        $totalStock = Stock::join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
        ->whereYear('tanggal', '=', $year)
        ->sum('tstock.stock');
            $showDataStock = Stock::join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
                ->join('master_data as md', 'stocks.master_data', '=', 'md.id')
                ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
                ->join('uoms', 'md.uom', '=', 'uoms.id')
                ->whereYear('tanggal', '=', $year)
                ->select('stocks.*','tstock.stock as qty', 'md.no_article', 'md.description','md.id as mdid', 'mg.name as mgname', 'uoms.name as uomname', 'tstock.tanggal')
                ->paginate(25);
        return view('content.stock.annual', compact('showDataStock','year','totalStock'))
            ->with('i');
        ;
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

    public function detailReportToday($id,$tanggal,$jumlah){
            $detailStock = Report::join('master_data as md','reports.master_data','=','md.id')
            ->join('users','reports.reporter','users.id')
            ->join('stations','users.station','stations.id')
            ->join('regions','users.region','regions.id')
            ->select('users.username as asu','regions.name as region','stations.name as station','jumlah')
            ->where('reports.master_data',$id)
            ->where('reports.reporting_date',$tanggal)
            ->paginate(25);
            $itemname = MasterData::findOrFail($id)->first();
            return view('content.stock.detail.today',compact('detailStock','tanggal','jumlah','itemname'))
            ->with('i');
    }

   
}
