<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LemburExport implements FromQuery, WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;
    public $awal;
    public $akhir;

    public function __construct($periode)
    {
        $period      = explode(' - ', $periode);
        $this->awal  = Carbon::parse($period[0])->format('Y-m-d');
        $this->akhir = Carbon::parse($period[1])->format('Y-m-d');
    }

    public function query()
    {
        $admin_id = Auth::user()->id_admin;
        return Lembur::query()
            ->select(['users.nama', 'lemburs.lembur_awal', 'lemburs.lembur_akhir', 'lemburs.jam_kerja', 'lemburs.jam_lembur', 'lemburs.lembur_keterangan', 'lemburs.lembur_status'])
            ->join('users', 'lemburs.id_user', '=', 'users.id')
            ->where('users.id_admin', $admin_id)
            ->whereBetween('lembur_awal', [$this->awal, $this->akhir]);
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Jam Kehadiran',
            'Jam Pulang',
            'Jam Kerja',
            'Jam Lembur',
            'Keterangan',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'size'      =>  15,
                    'bold'      =>  true,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'argb' => 'FF005555',
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 25,
            'C' => 25,
            'D' => 15,
            'E' => 15,
            'F' => 75,
            'G' => 25,
        ];
    }
}
