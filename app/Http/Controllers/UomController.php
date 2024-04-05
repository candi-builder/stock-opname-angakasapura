<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function index(){
        $uom = Uom::paginate(10);
        return view("content.uom.list", compact("uom"))->with('i');
    }

    public function processAdd(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:uoms'
        ]);

        $item = Uom::create([
            'name' => $request->name
        ]);
        return redirect()->route('get-list-uom')->with('success', 'Data Berhasil Disimpan');
    }

    public function formEdit($id){
        $uom = Uom::where('id', $id)->first();
        return view('content.uom.form-edit', compact('uom'));
    }

    public function processEdit(Request $request){
        $request->validate([
            'name'=> 'required|unique:uoms'
        ],[
            'name' => 'Nama uom tidak boleh kosong'
        ]);
        try {
            $item = Uom::findOrFail($request->input('id'));
            if (!$item) {
                return redirect()->route('get-list-uom')->with('error','uom tidak ditemukan');
            } 
            $item->update([
                'name' => $request->input('name'),
            ]);
            $item->save();
            return redirect()->route('get-list-uom')->with('success','Berhasil mengubah data');
        } catch (\Exception $e) {
            return redirect()->route('get-list-uom')->with('error','Terjadi Kesalahan');
        };
    }

    public function processDelete(string $id){
        try{
            $item = Uom::destroy($id);
            if ($item) {
                return redirect()->route('get-list-uom')->with('success','Berhasil Menghapus Data');
            } else {
                return redirect()->route('get-list-uom')->with('error','Gagal Menghapus Data');
            }
        } catch (\Exception $e){
            return redirect()->route('get-list-uom')->with('error', 'Terjadi Kesalahan');
        }
    }

    public function search(Request $request){
        $search = $request->input('cari');
        $uom = Uom::where('name','like','%'.$search.'%')->paginate();

        return view('content.uom.list', compact('uom'))->with('i');
    }
}
