<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    // function ini untuk menampilkan semua data
  public function index()
  {
    $station = Station::paginate(10);
    return view('content.station.list', compact('station'))->with('i');
  }

  // menampilkan halaman create station
  public function formAdd()
  {
    return view('content.station.form-add');
  }

  public function processAdd(Request $request)
  {
    // validate form
    $this->validate($request, [
      'name' => 'required|unique:stations',
    ]);

    // create station
    $item = Station::create([
      'name' => $request->name,
    ]);
    $item->save();

    return redirect()
      // redirect to index
      ->route('get-list-station')
      ->with(['success' => 'Data Berhasil Disimpan']);
  }

  // menampilkan halaman edit data yang dipilih
  public function formEdit(Request $request, $id)
  {
   $station = Station::where('id', $id)->first();
   return view ('content.station.form-edit', compact('station'));
  }

  // mengedit data yang dipilih
  public function processEdit(Request $request)
  {
   $request->validate(
    [
    'name' => 'required|unique:stations'
    ],
    [
    'name'=> 'Nama station tidak boleh kosong',
    ]
  );
  try {
      $item = Station::findOrFail( $request->input('id') );
      if (!$item) {
        return redirect()->route('edit-station')->with(['success'=> 'station tidak ditemukan']);
      }
      $item->update([
        'name'=> $request->input('name')
      ]);
      $item->save();
      return redirect()->route('get-list-station')->with('success','Berhasil mengubah data station');
    } catch (\Exception $e) {
        dd($e);
        return redirect()->route('get-list-station')->with('error','terjadi kesalahan');
      }

  }

  public function processDelete(string $id){
    try{
      $deleted = Station::destroy($id);

      if ($deleted) {
        return redirect()->route('get-list-station')->with('success','Berhasil menghapus data station');
      } else {
        return redirect()->route('get-list-station')->with('error','Gagal menghapus station');
      }
    } catch (\Exception $e){
      return redirect()->route('get-list-station')->with('error', 'terjadi kesalahan');
    }
  }

  public function search(Request $request){
    $search = $request->input('cari');
    $station = Station::where('name','LIKE','%'.$search.'%')->paginate(10);

    return view('content.station.list', compact('station'))->with('i');
  }
}
