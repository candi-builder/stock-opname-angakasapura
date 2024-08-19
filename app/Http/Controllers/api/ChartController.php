<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $dataChart = TStock::join('reports', 't_stocks.report_id', '=', 'reports.id')
    ->join('users', 'reports.reporter', '=', 'users.id')
    ->select('t_stocks.bulan', DB::raw('COUNT(users.username) as user_count'))
    ->groupBy('t_stocks.bulan')
    ->get();

        return response()->json([
          'status' => true,
          'pesan' => 'Data ditemukan',
          'data' => $dataChart,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
