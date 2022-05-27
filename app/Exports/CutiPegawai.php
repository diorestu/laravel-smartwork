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

class CutiPegawai implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $user;

    public function __construct(string $user)
    {
        $this->user   = $user;
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
            'title'          => 'Rekap Cuti Pegawai per Pegawai',
            'description'    => 'Rekap Cuti Pegawai per Pegawai',
            'subject'        => 'Rekap Cuti Pegawai per Pegawai',
            'keywords'       => 'cuti, cuti per pegawai',
            'category'       => 'Rekap Cuti Pegawai per Pegawai',
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
                        ->where('cutis.id_user',  $this->user)->count();
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
                        ->where('cutis.id_user',  $this->user)->get();

        return view('admin.cuti.expor_data.pegawai_cuti', [
            'data'      => $data,
            'user'    => $this->user,
        ]);
    }
}
