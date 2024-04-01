<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use App\Models\Region;
use App\Models\Report;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function index()
    {
        $userSession = Session::get('userSession');
        $dataReport = Report::join('users','reports.reporter','=','users.id')
            ->join('master_data as md','reports.master_data','=','md.id')
            ->join('material_groups as mg','md.material_group','=','mg.id')
            ->join('uoms','md.uom','=','uoms.id')
            ->select('reports.id','reporting_date','md.no_article','md.description','mg.name as mgname','uoms.name as uomname','users.username')
            ->where('users.username',$userSession->username)
            ->paginate(25);
        $stationUser = Station::where('id',$userSession->station_id)->first();
        $regionUser = Region::where('id',$userSession->region_id)->first();
        $md = MasterData::select('id','no_article','description')->get();
        return view('content.report.list', compact('dataReport','md','stationUser','regionUser'))
            ->with('i');
        
    }
}
