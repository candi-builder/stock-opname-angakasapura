<?php
namespace App\Exports;

use App\Models\TStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Session;

class MonthlyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        $heading = [
            'NO',
            'NEW ARTICLE NO.',
            'MATERIAL GROUP',
            'NEW DESCRIPTION',
            'UOM',
            'TOTAL STOCK',
            'BULAN'
        ];
        return $heading;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A'=>['alignment' => ['horizontal' => 'center']],
            'B'=>['alignment' => ['horizontal' => 'center']],
            'C'=>['alignment' => ['horizontal' => 'center']],
            'D'=>['alignment' => ['horizontal' => 'center']],
            'E'=>['alignment' => ['horizontal' => 'center']],
            'F'=>['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function collection()
    {
        $currentDate = Carbon::now();
        $dateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate);
        if (!Session::has('monthlyHistory')) {
            Session::put('monthlyHistory', $dateFormat->month);
        }
        $month = Session::get('monthlyHistory');
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return DB::table('stocks')
            ->join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
            ->join('master_data as md', 'stocks.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->where('bulan', '=', $month)
            ->select('md.no_article','mg.name as material_groups','md.description','uoms.name as uoms', 'stocks.stock', 'bulan')
            ->get();
    }

    public function map($row): array{
        static $rowNumber = 0;  

        $rowNumber++;

        $data = [
            'No' => $rowNumber,
            'NEW ARTICLE NO.' => $row->no_article,
            'MATERIAL GROUP' => $row->material_groups,
            'NEW DESCRIPTION' => $row->description,
            'UOM' => $row->uoms,
            'TOTAL STOCK' => $row->stock,
            'BULAN' => $row->bulan
        ];

        return $data;
    }
}