<?php

namespace App\Http\Controllers;

use App\Models\MaterialGroup;
use Illuminate\Http\Request;

class MaterialGroupController extends Controller
{
    public function index(){
        $materialGroup = MaterialGroup::paginate(10);
        return view("content.material-group.list", compact('materialGroup'))->with('i');
    }

    public function processAdd(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:material_groups'
        ]);

        MaterialGroup::create([
            'name' => $request->name
        ]);

        return redirect()->route('get-list-material-group')->with('success', 'Data Berhasil Disimpan');
    }

    public function formEdit($id){
        $materialGroup = MaterialGroup::where('id', $id)->first();
        return view('content.material-group.form-edit', compact('materialGroup'));
    }

    public function processEdit(Request $request){
        $request->validate([
            'name' => 'required|unique:material_groups'
        ],[
            'name'=> 'Nama material group harus diisi'
        ]);
        try{
            $item = MaterialGroup::findOrFail($request->input('id'));
            if(!$item){
                return redirect()->route('edit-material-group')->with('error','Data tidak ditemukan');
            }
            $item->update([
                'name'=>$request->input('name')
            ]);
            $item->save();
            return redirect()->route('get-list-material-group')->with('success','Berhasil mengubah data material group');
        } catch (\Exception $e) {
            return redirect()->route('get-list-material-group')->with('error','terjadi kesalahan');
        }
    }

    public function processDelete(string $id){
        try{
            $deleted = MaterialGroup::destroy($id);
            if ($deleted){
                return redirect()->route('get-list-material-group')->with('success', 'Berhasil Menghapus Data');
            } else {
                return redirect()->route('get-list-material-group')->with('error', 'Gagal Menghapus Data');
            }
        } catch (\Exception $e) {
            return redirect()->route('get-list-material-group')->with('error', 'terjadi kesalahan');
        }
    }
}
