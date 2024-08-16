<?php

namespace App\Http\Controllers;

use App\Models\BatasanStockStation;
use App\Models\MasterData;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BatasanStockStationController extends Controller
{
  public function index(){
    $userSession = Session::get('userSession');
    $showDataBatasanStockStation = BatasanStockStation::join('stations','batasan_stock_stations.station_id', '=', 'stations.id')
        ->join('master_data as md', 'batasan_stock_stations.item_id', '=', 'md.id')
        ->selectRaw('stations.name, md.description, batasan_stock_stations.batasan')
        ->paginate(25);
    $md = MasterData::select('id', 'no_article', 'description')->get();
    $userStations = Station::select('id','name')->get();
    return view('content.batasan-stock.list-batasan-stock', compact('showDataBatasanStockStation', 'md', 'userStations'))->with('i');
  }

  public function formAddBatasanStock(){
    return view('content.batasan-stock.form-add-batasan-stock');
  }

  public function processAddBatasanStock(Request $request){
    $request->validate(
      [
          'userStations' => 'required',
          'item' => 'required',
          'batasan_stock' => 'required|integer',
      ],
      [
          'userStations.required' => 'pilih station terlebih dahulu',
          'item.required' => 'pilih item terlebih dahulu',
          'batasan_stock.required' => 'masukan batasan stock',
          'batasan_stock.integer' => 'batasan stock wajib angka',
      ]
  );
  $userSession = Session::get('userSession');
    try {
      $isAdmin = $userSession->role;
      if ($isAdmin == 'user') {
        return redirect()->route('login')->with('error','user tidak bisa membuat batasan stock.');
      }
      DB::beginTransaction();
          $batasanStockStation = new BatasanStockStation([
              'station_id' => $request->input('userStations'),
              'item_id' => $request->input('item'),
              'batasan' => $request->input('batasan_stock')
          ]);
      $batasanStockStation->save();
      DB::commit();
      return redirect()->route('list-batasan-stock-station')->with('success','Batasan stock berhasil ditambahkan');
    } catch (\Exception $e) {
      dd($e);
      return redirect()->route('list-batasan-stock-station')->with('error','Gagal menambahkan batasan stock');
    }
  }
}
