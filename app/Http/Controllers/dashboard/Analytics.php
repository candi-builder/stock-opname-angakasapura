<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\MasterData;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Analytics extends Controller
{
  public function index()
  {
    $isAdmin = Session::get('userSession')->role == 'superadmin';
    
    if ($isAdmin) {
      return redirect()->route('get-list-report-admin');
    }
    return redirect()->route('get-list-report');
   
  }
}
