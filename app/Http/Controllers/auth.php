<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Station;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class auth extends Controller
{
    public function index()
    {
        $users = User::join('stations', 'users.station', '=', 'stations.id')
            ->join('regions', 'users.region', '=', 'regions.id')
            ->select('users.username', 'users.id', 'stations.name as station', 'regions.name as region')
            ->get();
        return view('content.user.list', compact('users'))->with('i');
    }
    public function formDaftarUser()
    {
        $stations = Station::get();
        $regions = Region::get();

        return view('content.user.form-add', compact('stations', 'regions'));
    }
    public function formChangePassword()
    {
        return view('content.user.change-password');
    }
    public function formLogin()
    {
        return view('content.user.login');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function register(Request $request)
    {
        $request->validate(
            [
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
            ]
        );

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse returned
     */
    public function processLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username harus diisi.',
                'password.required' => 'Password harus diisi.',
            ]
        );

        try {
            $login = User::where('users.username', '=', $username)->first();
            $stationUser = Station::where('id', $login->station)->first();
            $regionUser = Region::where('id',$login->region)->first();
            if ($login == null) {
                $userSession = new UserSession(0,false, '', '', 0, 0);
                return redirect()->route('login')->with('error', 'username belum terdaaftar,hubungi admin untuk mendaftar');
            }
            if ($password != $login->password) {
                
                $userSession = new UserSession(0,false, '', '', 0, 0);
                return redirect()->route('login')->with('error', 'password yang anda masukan salah');
            }
            $userSession = new UserSession($login->id,true, $login->username, $login->role, $stationUser, $regionUser);
            Session::put('userSession', $userSession);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi Kesalahan.');
        }
    }

    public function forgotPW()
    {
        return redirect()->route('login')->with('error', 'hubungi admin untuk merubah password');
    }

    public function changePw(Request $request){
        
        $password = $request->input('password');
        $request->validate(
            [
                'password' => 'required',
                'confirmpw' => 'required|same:password',
            ],
            [
                'password.required' => 'password baru harus diisi.',
                'confirmpw.required' => 'konfirmasi password harus diisi.',
                'confirmpw.same' => 'Konfirmasi password harus sama dengan password baru.',
            ]
        );

        try {
            $username = Session::get('userSession')->username;
            $changePw = User::where('username',$username)->first();
            $changePw->update([
                'password' => $password,
            ]);
            return redirect()->route('change-password')->with('success', 'berhasil mengubah password');
        } catch (\Exception $e) {
            return redirect()->route('change-password')->with('error', 'terjadi kesalahan');

        }
    }

    public function resetPw(Request $request,$id){
        

        try {
            $changePw = User::findOrFail($id);
            $changePw->update([
                'password' => $changePw->username,
            ]);
            return redirect()->route('get-list-user')->with('success', 'password di reset menjadi '.$changePw->username);
        } catch (\Exception $e) {
            return redirect()->route('get-list-user')->with('error', 'terjadi kesalahan');

        }
    }

    public function deleteUser(Request $request,$id){
        try {
            $deleted = User::destroy($id);
        
            if ($deleted) {
                return redirect()->route('get-list-user')->with('success', 'Berhasil menghapus user');
            } else {
                return redirect()->route('get-list-user')->with('error', 'Gagal menghapus user');
            }
        } catch (\Exception $e) {
            return redirect()->route('get-list-user')->with('error', 'terjadi kesalahan');

        }
    }

    public function logout()
    {
        Session::forget('userSession');
        return redirect()->route('login');
    }
}
