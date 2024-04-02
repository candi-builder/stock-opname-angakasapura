<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
  // function ini untuk menampilkan semua data
  public function index()
  {
    $region = Region::paginate(10);
    return view('content.region.list', compact('region'))->with('i');
  }

  // menampilkan halaman create region
  public function formAdd()
  {
    return view('content.region.form-add');
  }

  // memasukkan data ke dalam database
  public function processAdd(Request $request)
  {
    // validate form
    $this->validate($request, [
      'name' => 'required|unique:regions',
    ]);

    // create region
    Region::create([
      'name' => $request->name,
    ]);

    return redirect()
      // redirect to index
      ->route('get-list-region')
      ->with(['success' => 'Data Berhasil Disimpan']);
  }

  // menampilkan halaman edit data yang dipilih
  public function formEdit(Request $request, $id)
  {
   $region = Region::where('name', $id)->first();
   return view ('content.region.form-edit', compact('region'));
  }

  // mengedit data yang dipilih
  public function processEdit(Request $request)
  {
   $request->validate(
    [
    'name' => 'required|unique:regions'
    ],
    [
    'name'=> 'Nama region tidak boleh kosong',
    ]
  );
  try {
      $item = Region::where('name', $request->input('name'));
      if (!$item) {
        return redirect()->route('edit-region')->with(['success'=> 'Region tidak ditemukan']);
      }
      $item->update([
        'name'=> $request->input('name')
      ]);
      return redirect()->route('edit-region')->with('success','Berhasil mengubah data region');
      } catch (\Exception $e) {
        return redirect()->route('edit-region')->with('error','terjadi kesalahan');
      }

  }

  public function processDelete(string $id){
    try{
      $deleted = Region::destroy($id);

      if ($deleted) {
        return redirect()->route('get-list-region')->with('success','Berhasil menghapus data region');
      } else {
        return redirect()->route('get-list-region')->with('error','Gagal menghapus region');
      }
    } catch (\Exception $e){
      return redirect()->route('get-list-region')->with('error', 'terjadi kesalahan');
    }
  }
}