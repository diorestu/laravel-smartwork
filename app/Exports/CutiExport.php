<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Cuti;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CutiExport implements FromQuery, WithHeadings, WithStyles, WithColumnWidths
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
        return Cuti::query()
            ->select(['users.nama', 'cutis.cuti_awal', 'cutis.cuti_akhir', 'cutis.cuti_status', 'cutis.cuti_deskripsi'])
            ->join('users', 'cutis.id_user', '=', 'users.id')
            ->where('users.id_admin', $admin_id)
            ->whereBetween('cuti_awal', [$this->awal, $this->akhir]);
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Mulai',
            'Selesai',
            'Status',
            'Keterangan',
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
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FF005555',
                    ],
                    'endColor' => [
                        'argb' => 'FF125B50',
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 80,
        ];
    }
}
