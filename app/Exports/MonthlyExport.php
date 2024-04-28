<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlyExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    use Exportable;
    protected $month;
    protected $year;

    public function headings(): array
    {
        return [
            'NEW ARTICLE NO.',
            'MATERIAL GROUP',
            'NEW DESCRIPTION',
            'UOM',
            'STATION',
            'REGION'
        ];

    }

    public function map($export):array
    {
        return [
        ];
    }

    public function __construct()
    {
        $this->month = session('monthlyHistory');
        $this->year = session('annualHistory');
    }

    public function collection()
    {
        return DB::table('stocks')
            ->join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
            ->join('master_data as md', 'stocks.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->join('reports','md.id','=', 'reports.master_data')
            ->join('users','reports.reporter','=','users.id')
            ->join('stations','users.station','=','stations.id')
            ->join('regions','users.region','=','regions.id')
            ->whereMonth('tstock.tanggal', '=', $this->month)
            ->whereYear('tstock.tanggal', '=', $this->year)
            ->select('md.no_article','mg.name','md.description','uoms.name')
            ->get();


    }
    
}
