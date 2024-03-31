<?php

namespace App\Http\Controllers;


use App\Models\MasterData;
use App\Models\MaterialGroup;
use App\Models\Uom;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {

        $dataItems = MasterData::join('material_groups as mg', 'master_data.material_group', '=', 'mg.id')
            ->join('uoms', 'master_data.uom', '=', 'uoms.id')
            ->select('master_data.*', 'uoms.name', 'mg.name')
            ->paginate(5);
        return view('content.item.list', compact('dataItems'))
        ->with('i');

    }

    public function formAdd(){
        $mg = MaterialGroup::get();
        $uoms = Uom::get();
        return view('content.item.form-add',compact('mg','uoms'));
    }
}
