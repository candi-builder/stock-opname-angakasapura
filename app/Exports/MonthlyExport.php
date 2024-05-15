<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        // Mendapatkan nama semua stasiun
        $stations = DB::table("stations")->select('name')->get();
        
        // Membuat heading awal
        $heading = [






































            
            'NO',
            'NEW ARTICLE NO.',
            'MATERIAL GROUP',
            'NEW DESCRIPTION',
            'UOM',
            'TOTAL STOCK',
        ];

        // Menambahkan nama stasiun sebagai heading tambahan
        foreach ($stations as $station) {
            $heading[] = $station->name;
        }

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
        return DB::table('stocks')
            ->join('t_stocks as tstock', 'stocks.id', '=', 'tstock.item_id')
            ->join('master_data as md', 'stocks.master_data', '=', 'md.id')
            ->join('material_groups as mg', 'md.material_group', '=', 'mg.id')
            ->join('uoms', 'md.uom', '=', 'uoms.id')
            ->select('md.no_article','mg.name as material_groups','md.description','uoms.name as uoms', 'stocks.stock')
            ->get();
    }

    public function map($row): array{
        // Incremental counter untuk nomor urut
        static $rowNumber = 0;

        // Increment counter untuk setiap baris
        $rowNumber++;

        // Mendapatkan nama semua stasiun
        $stations = DB::table("stations")->select('name')->get();

        // Mendapatkan nilai stok untuk setiap stasiun
        $stockByStation = [];

        foreach ($stations as $station) {
            // Query untuk mendapatkan stok untuk setiap stasiun
            $stock = DB::table('station_stocks')
                ->where('station_id', $station->id) // Ubah menjadi kondisi yang sesuai dengan struktur tabel Anda
                ->where('stock_id', $row->id) // Ubah menjadi kondisi yang sesuai dengan struktur tabel Anda
                ->value('stock');

            $stockByStation[$station->name] = $stock ?? ''; // Menambahkan nilai stok ke dalam array, jika stok tidak ditemukan, gunakan string kosong
        }

        // Membuat data untuk baris saat ini
        $data = [
            'No' => $rowNumber,
            'NEW ARTICLE NO.' => $row->no_article,
            'MATERIAL GROUP' => $row->material_groups,
            'NEW DESCRIPTION' => $row->description,
            'UOM' => $row->uoms,
            'TOTAL STOCK' => $row->stock,
        ];

        // Menambahkan nilai stok untuk setiap stasiun ke dalam data
        foreach ($stockByStation as $stationName => $stock) {
            $data[$stationName] = $stock;
        }

        return $data;
    }
}