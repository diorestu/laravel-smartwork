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

class LemburPegawai implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $user, $awal, $akhir;

    public function __construct(string $user, string $awal, string $akhir)
    {
        $this->user = $user;
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
            'title'          => 'Rekap Lembur Pegawai per Pegawai',
            'description'    => 'Rekap Lembur Pegawai per Pegawai',
            'subject'        => 'Rekap Lembur Pegawai per Pegawai',
            'keywords'       => 'lembur, lembur per pegawai',
            'category'       => 'Rekap Lembur Pegawai per Pegawai',
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
        $data       = Lembur::where('id_user', $this->user)->whereBetween('lembur_awal', [$this->awal, $this->akhir])->count();
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
        $data   = Lembur::where('id_user', $this->user)->whereBetween('lembur_awal', [$this->awal, $this->akhir])->get();

        return view('admin.lembur.expor_data.pegawai_lembur', [
            'data'      => $data,
            'user'      => $this->user,
            'awal'      => $this->awal,
            'akhir'     => $this->akhir,
        ]);
    }
}
