<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;

class auth extends Controller
{
    public function index()
    {
        $users = User::join('stations','users.station', '=' ,'stations.id')
        ->join('regions','users.region','=','regions.id')
        ->select('users.username','users.id','stations.name as station','regions.name as region')
        ->get();
        return view('content.user.list', compact('users'))->with('i');
    }
    public function formDaftarUser()
    {
        $stations = Station::get();
        $regions = Region::get();

        return view('content.user.form-add', compact('stations','regions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'station' => 'required',
            'region' => 'required',
        ],
        [
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'station.required' => 'Station harus dipilih.',
            'region.required' => 'Region harus dipilih.',
        ]);

        try {
            $register = new User([
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'region' => $request->input('region'),
                'station' => $request->input('station'),
            ]);
    
            $register->save();
            
            return redirect()->route('get-list-user')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('add-new-user')->with('error', 'Gagal menambahkan user.');
        }
    }
}
