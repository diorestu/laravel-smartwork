<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JadwalTemplateExport implements WithProperties, FromView, WithColumnWidths, WithStyles, Responsable
{
    use Exportable;
    private $fileName = 'template jadwal kerja.xlsx';
    private $writerType = Excel::XLSX;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 4,
            'C' => 31,
            'D' => 16,
            'E' => 16,
            'F' => 4, 'G' => 4, 'H' => 4, 'I' => 4, 'J' => 4, 'K' => 4, 'L' => 4, 'M' => 4, 'N' => 4, 'O' => 4,
            'P' => 4, 'Q' => 4, 'R' => 4, 'S' => 4, 'T' => 4, 'U' => 4, 'V' => 4, 'W' => 4, 'X' => 4, 'Y' => 4,
            'Z' => 4, 'AA' => 4, 'AB' => 4, 'AC' => 4, 'AD' => 4, 'AE' => 4, 'AF' => 4, 'AG' => 4, 'AH' => 4, 'AI' => 4,
            'AJ' => 4,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:AJ1')->getFont()->setBold(true);
        $sheet->getStyle('A1:AJ1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A2:B100')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('C2:C100')->getFont()->setBold(true);
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Template Impor Jadwal Kerja Pegawai',
            'description'    => 'Tempalate paten untuk mengimpor jadwal kerja pegawai secara cepat dengan periode tertentu',
            'subject'        => 'Template Impor Jadwal Kerja Pegawai',
            'keywords'       => 'shift,jadwal_kerja,impor',
            'category'       => 'Jadwal Kerja',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    protected $year, $month, $cabang;

    public function __construct(int $year, int $month, int $cabang)
    {
        $this->tahun    = $year;
        $this->bulan    = $month;
        $this->cabang   = $cabang;
    }

    public function view(): View
    {
        $data       = User::select('id', 'nama', 'id_cabang')
                            ->where('id_cabang', $this->cabang)
                            ->where('is_admin', '0');

        return view('admin.jadwal.expor_data.template', [
            'data' => $data->get(),
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }
}
