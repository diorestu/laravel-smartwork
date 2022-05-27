<?php

namespace App\Exports;

use App\Models\Lembur;
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

class LemburCabang implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
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
            'D' => 22,
            'E' => 41,
            'F' => 38,
            'G' => 47,
            'H' => 12,
            'I' => 12,
            'J' => 14,
            'K' => 27,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Rekap Lembur Pegawai per Cabang',
            'description'    => 'Rekap Lembur Pegawai per Cabang',
            'subject'        => 'Rekap Lembur Pegawai per Cabang',
            'keywords'       => 'lembur, lembur per cabang',
            'category'       => 'Rekap Lembur Pegawai per Cabang',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:K3')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A3:K3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        $id         = Auth::user()->id_admin;
        $data       = Lembur::leftJoin('users',         'users.id',             '=', 'lemburs.id_user')
                            ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                            ->where('users.id_cabang', $this->cabang)->whereBetween('lemburs.lembur_awal', [$this->awal, $this->akhir])->count();
        $jum        = $data + 3;
        $cellRange  = 'A3:K' . $jum;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:K1');
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
        $data   = Lembur::leftJoin('users',         'users.id',             '=', 'lemburs.id_user')
                        ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                        ->where('users.id_cabang', $this->cabang)->whereBetween('lemburs.lembur_awal', [$this->awal, $this->akhir])->get();

        return view('admin.lembur.expor_data.cabang_lembur', [
            'data'      => $data,
            'cabang'    => $this->cabang,
            'awal'      => $this->awal,
            'akhir'     => $this->akhir,
        ]);
    }
}
