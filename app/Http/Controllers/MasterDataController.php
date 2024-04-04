<?php

namespace App\Http\Controllers;


use App\Models\MasterData;
use App\Models\MaterialGroup;
use App\Models\Stock;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    public function index()
    {

        $dataItems = MasterData::join('material_groups as mg', 'master_data.material_group', '=', 'mg.id')
            ->join('uoms', 'master_data.uom', '=', 'uoms.id')
            ->select('master_data.*', 'uoms.name as uom_name', 'mg.name as mgname')
            ->paginate(25);
            $mg = MaterialGroup::get();
            $uoms = Uom::get();
        return view('content.item.list', compact('dataItems','mg','uoms'))
            ->with('i');
        
    }

    public function formAdd()
    {
        $mg = MaterialGroup::get();
        $uoms = Uom::get();
        return view('content.item.form-add', compact('mg', 'uoms'));
    }

    public function processAdd(Request $request)
    {
        $request->validate(
            [
                'no_article' => 'required|unique:master_data',
                'description' => 'required',
                'mg' => 'required',
                'uom' => 'required',
            ],
            [
                'no_article.required' => 'no article tidak boleh kosong',
                'mg.required' => 'mg tidak boleh kosong',
                'description.required' => 'description tidak boleh kosong',
                'uom.required' => 'uom tidak boleh kosong',
                'no_article.unique' => 'no article ini sudah dgipakai, tidak boleh sama',
            ]
        );
        try {
            DB::beginTransaction();
            $item = new MasterData([
                'no_article' => $request->input('no_article'),
                'description' => $request->input('description'),
                'material_group' => $request->input('mg'),
                'uom' => $request->input('uom'),
            ]);
            $item->save();
            $stock = new Stock([
                'master_data' => $item->id,
                'stock' => 0,
            ]);
            $stock->save();
            Db::commit();
            return redirect()->route('get-list-item')->with('success', 'Berhasil Menambah item baru');

        } catch (\Exception $e) {
            return redirect()->route('get-list  -item')->with('error', 'terjadi kesalahan');
        }
    }

    public function formEdit(Request $request,$id){
        $dataItem =  MasterData::join('material_groups as mg', 'master_data.material_group', '=', 'mg.id')
        ->join('uoms', 'master_data.uom', '=', 'uoms.id')
        ->select('master_data.*', 'uoms.name as uom_name', 'mg.name as mgname','mg.id as mg_id','uoms.id as uoms_id')
        ->where('no_article',$id)
        ->first();
        $mg = MaterialGroup::get();
        $uoms = Uom::get();
    return view('content.item.form-edit', compact('dataItem','uoms','mg'));
    }

    public function processEdit(Request $request)
    {
        $request->validate(
            [
                'no_article' => 'required|unique:master_data',
                'description' => 'required',
                'mg' => 'required',
                'uom' => 'required',
            ],
            [
                'no_article.required' => 'no article tidak boleh kosong',
                'mg.required' => 'mg tidak boleh kosong',
                'description.required' => 'description tidak boleh kosong',
                'uom.required' => 'uom tidak boleh kosong',
                'no_article.unique' => 'no article ini sudah dgipakai, tidak boleh sama',
            ]
        );
        try {
            $item = MasterData::where("no_article",$request->input('no_article'));
            if (!$item) {
            return redirect()->route('edit-item')->with('success', 'item tidak ditemukan');
                
            }
            $item->update([
                'description' => $request->input('description'),
                'material_group' => $request->input('mg'),
                'uom' => $request->input('uom'),
            ]);
            return redirect()->route('get-list-item')->with('success', 'Berhasil Memperbarui item baru');

        } catch (\Exception $e) {
            return redirect()->route('edit-item')->with('error', 'terjadi kesalahan');
        }
    }

    public function processDelete(Request $request,$id){
        try {
            $deleted = MasterData::destroy($id);
        
            if ($deleted) {
                return redirect()->route('get-list-item')->with('success', 'Berhasil menghapus item');
            } else {
                return redirect()->route('get-list-item')->with('error', 'Gagal menghapus item');
            }
        } catch (\Exception $e) {
            return redirect()->route('get-list-item')->with('error', 'terjadi kesalahan');

        }
    }
}
