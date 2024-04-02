<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $station = Station::paginate(10);
        return view('content.station.list', compact('station'))->with('i');
    }

    public function formAdd()
    {
        return view('content.station.form-add');
    }

    public function processAdd(Request $request)
    {
        $this->validate($request, [
            'name' =>'required',
        ]);

        Station::create([
            'name' => $request->name,
        ]);

        return redirect()->route('get-station-list')->with(['success'=> 'Data Berhasil Disimpan']);
    }

    public function formEdit(string $id)
    {
        $station = Station::findOrFail($id);
        return view('content.station.form-edit', compact('station'));
    }

    public function update(Request $request, string $id)
    {
        // $this->validate($request, [
    }

    /**
     * Remove the specified resource from storage.
     */
    public function processDelete(string $id)
    {
        try{
            $deleted = Station::destroy('name');

            if ($deleted) {
                return redirect()->route('get-list-station')->with('sucsess', 'Berhasil menghapus data');
            } else {
                return redirect()->route('get-station-list')->with('error','Gagal menghapus data');
            }
        } catch (\Exception $e) {
            return redirect()->route('get-list-station')->with('error', 'terjadi kesalahan');
        }
    }
}
