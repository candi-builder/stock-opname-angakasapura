<?php

namespace App\Exports;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailMonth implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;
    public function __construct($id)
    {
        $this-> id = $id;
    }
    public function collection()
    {
        return DB::table('reports')
        ->join('users', 'reports.reporter', '=', 'users.id')
        ->join('master_data as md', 'reports.master_data', '=', 'md.id')
        ->join('stocks', 'md.id', '=', 'stocks.master_data')
        ->join('stations','users.station', '=', 'stations.id')
        ->join('regions', 'users.region', '=', 'regions.id')
        ->select('users.username', 'stations.name as stations', 'regions.name as regions', 'stocks.stock')
        ->where('reports.master_data', $this->id)
        ->get();
    }

    public function headings(): array
    {
        $heading = [
            'NO',
            'REPORTER',
            'STATION',
            'REGION',
            'JUMLAH YANG DIMASUKKAN'
        ];

        return $heading;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A' =>['alignment' => ['horizontal' => 'center']] ,
            'B' =>['alignment' => ['horizontal' => 'center']] ,
            'C' =>['alignment' => ['horizontal' => 'center']] ,
            'D' =>['alignment' => ['horizontal' => 'center']] ,
            'E' =>['alignment' => ['horizontal' => 'center']] ,
        ];
    }

    public function map($row): array {
        static $rowNumber = 0;

        $rowNumber++;

        $data = [
            'NO' => $rowNumber,
            'REPORTER' => $row->username,
            'STATION' => $row->stations,
            'REGION' => $row->regions,
            'JUMLAH YANG DIMASUKKAN' => $row->stock
        ];

        return $data;
    }
}
