<?php

namespace App\Exports;

use App\Models\Aktivitas;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AktivitasCabang implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $cabang, $awal, $akhir;

    public function __construct(string $cabang, string $awal, string $akhir)
    {
        $this->cabang = $cabang;
        $this->awal = $awal;
        $this->akhir = $akhir;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 40,
            'C' => 19,
            'D' => 30,
            'E' => 70,
            'F' => 20,
            'G' => 25,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Rekap Aktivitas Pegawai per Cabang',
            'description'    => 'Rekap Aktivitas Pegawai per Cabang',
            'subject'        => 'Rekap Aktivitas Pegawai per Cabang',
            'keywords'       => 'aktivitas, aktivitas per cabang',
            'category'       => 'Rekap Aktivitas Pegawai per Cabang',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:G3')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        $data       = Aktivitas::leftJoin('users',          'users.id',             '=', 'aktivitas.id_user')
                                ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                ->where('users.id_cabang', $this->cabang)
                                ->whereBetween('aktivitas.created_at', [$this->awal, $this->akhir])->count();

        $jum        = $data + 3;
        $cellRange  = 'A3:G' . $jum;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:G1');
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
    public function view(): View
    {
        $data       = Aktivitas::leftJoin('users',          'users.id',             '=', 'aktivitas.id_user')
                                ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                ->where('users.id_cabang', $this->cabang)
                                ->whereBetween('aktivitas.created_at', [$this->awal, $this->akhir])->get();

        return view('admin.aktivitas.expor_data.cabang_aktivitas', [
            'data'      => $data,
            'cabang'    => $this->cabang,
            'awal'      => $this->awal,
            'akhir'     => $this->akhir,
        ]);
    }
}
