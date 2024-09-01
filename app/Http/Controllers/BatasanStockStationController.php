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
        ->selectRaw('batasan_stock_stations.id, stations.name, md.description, batasan_stock_stations.batasan')
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
      return redirect()->route('list-batasan-stock-station')->with('error','Gagal menambahkan batasan stock');
    }
  }

  public function formEditBatasanStock(Request $request, $id){
    $showDataBatasanStockStation = BatasanStockStation::join('stations','batasan_stock_stations.station_id', '=', 'stations.id')
    ->join('master_data as md', 'batasan_stock_stations.item_id', '=', 'md.id')
    ->selectRaw('batasan_stock_stations.id, stations.name, md.description, batasan_stock_stations.batasan')
    ->where('batasan_stock_stations.id', $id)
    ->first();
    $md = MasterData::select('id', 'no_article', 'description')->get();
    $userStations = Station::select('id','name')->get();
    return view('content.batasan-stock.form-edit-batasan-stock', compact('showDataBatasanStockStation', 'md', 'userStations'));
  }

  public function processEditBatasanStock(Request $request){
    $request->validate([
      'userStations' => 'required',
      'item' => 'required',
      'batasan_stock' => 'required|integer'
    ],
    [
      'userStations' => 'user stations tidak boleh kosong',
      'item' => 'item tidak boleh kosong',
      'batasan_stock.integer' => 'batasan stock wajib angka'
    ]);
    try {
      $item = BatasanStockStation::where("userStations", $request->input('userStations'));
      if (!$item) {
        return redirect()->route('list-batasan-stock-station')->with('error', 'data tidak ditemukan');
      }
      $item->update([
        'item' => $request->input('item'),
        'batasan' => $request->input('batasan_stock')
      ]);
      return redirect()->route('list-batasan-stock-station')->with('success', 'berhasil mengupdate batasan');
    } catch (\Exception $e) {
      dd($e);
      return redirect()->route('get-list-station')->with('error', 'terjadi kesalahan');
    }
  }

  public function processDelete($id){
    try {
      $deleted = BatasanStockStation::destroy($id);
      if (!$deleted) {
        return redirect()->route('list-batasan-stock-station')->with('error', 'batasan stock gagal dihapus');
      } else {
        return redirect()->route('list-batasan-stock-station')->with('success', 'batasan stock berhasil dihapus');
      }
    } catch (\Exception $e) {
      return redirect()->route('list-batasan-stock-station')->with('error', 'terjadi kesalahan');;
    }
  }
}
