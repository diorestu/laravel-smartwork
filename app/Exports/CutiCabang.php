<?php

namespace App\Exports;

use App\Models\Cuti;
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

class CutiCabang implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $cabang;

    public function __construct(string $cabang)
    {
        $this->cabang   = $cabang;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 40,
            'C' => 19,
            'D' => 24,
            'E' => 35,
            'F' => 16,
            'G' => 13,
            'H' => 15,
            'I' => 26,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Rekap Cuti Pegawai per Cabang',
            'description'    => 'Rekap Cuti Pegawai per Cabang',
            'subject'        => 'Rekap Cuti Pegawai per Cabang',
            'keywords'       => 'cuti, cuti per cabang',
            'category'       => 'Rekap Cuti Pegawai per Cabang',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:I3')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        $id     = Auth::user()->id_admin;
        $data   = Cuti::leftJoin('users',           'users.id',       '=', 'cutis.id_user')
                        ->leftJoin('cabangs',       'cabangs.id',     '=', 'users.id_cabang')
                        ->where('users.id_cabang',  $this->cabang)->count();
        $jum        = $data + 3;
        $cellRange  = 'A3:I' . $jum;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:I1');
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
        $id     = Auth::user()->id_admin;
        $data   = Cuti::leftJoin('users',           'users.id',       '=', 'cutis.id_user')
                        ->leftJoin('cabangs',       'cabangs.id',     '=', 'users.id_cabang')
                        ->where('users.id_cabang',  $this->cabang)->get();

        return view('admin.cuti.expor_data.cabang_cuti', [
            'data'      => $data,
            'cabang'    => $this->cabang,
        ]);
    }
}
