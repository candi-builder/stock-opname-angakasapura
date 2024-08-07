<?php

namespace App\Http\Controllers;

use App\Models\BatasanStockStation;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BatasanStockStationController extends Controller
{
  public function index(){
    $userSession = Session::get('userSession');
    $showDataBatasanStockStation = BatasanStockStation::join('stations','batasan_stock_stations.station_id', '=', 'stations.id')
        ->join('master_data as md', 'batasan_stock_stations.item_id', '=', 'md.id')
        ->selectRaw('stations.name, md.description, batasan_stock_station.batasan')
        ->paginate(25);
    return view('content.batasan-stock.list-batasan-stock', compact('showDataBatasanStockStation'))->with('i');
  }

  public function formAddBatasanStock(){
    return view('content.batasan-stock.form-add-batasan-stock');
  }

  public function processAddBatasanStock(Request $request){
    $request->validate(
      [
          'users' => 'required',
          'item' => 'required',
          'batasan_stock' => 'required|integer',
      ],
      [
          'users.required' => 'pilih users terlebih dahulu',
          'item.required' => 'pilih item terlebih dahulu',
          'batasan_stock.required' => 'masukan batasan stock',
          'batasan_stock.integer' => 'batasan stock wajib angka',
      ]
  );
  $userSession = Session::get('userSession');
  $existingStock = Stock::where('master_data', $request->input('item'))->first();
    try {
      $isAdmin = $userSession->role;
      if ($isAdmin == 'user') {
        return redirect()->route('login')->with('error','user tidak bisa membuat batasan stock.');
      }
      return redirect()->route('get-list-report-admin')->with('success','Batasan stock berhasil ditambahkan');
    } catch (\Exception $e) {
      dd($e);
      return redirect()->route('get-list-report-admin')->with('error','Gagal menambahkan batasan stock');
    }
  }
}
