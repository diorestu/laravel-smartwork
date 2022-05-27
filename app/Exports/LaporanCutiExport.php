<?php

namespace App\Exports;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanCutiExport implements FromView, WithColumnFormatting, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $id_user;
    protected $awal;
    protected $akhir;

    public function __construct(int $id_user, string $awal, string $akhir)
    {
        $this->user     = $id_user;
        $this->awl      = $awal;
        $this->akh      = $akhir;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 40,
            'C' => 19,
            'D' => 23,
            'E' => 23,
            'F' => 43,
            'G' => 11,
            'H' => 11,
            'I' => 25,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Laporan Cuti Pegawai',
            'description'    => 'Laporan Cuti Pegawai',
            'subject'        => 'Laporan Cuti Pegawai',
            'keywords'       => 'cuti, perhitungan cuti, jatah cuti',
            'category'       => 'Laporan Cuti Pegawai',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A3:I3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $data       = Cuti::where('id_user', $this->user)->whereBetween('cuti_awal', [$this->awl, $this->akh])->count();
        $jum        = $data + 3;
        $total      = $jum + 1;
        $sheet->setCellValue("G{$total}", "=SUM(G4:G{$jum})");
        $sheet->getStyle("F{$total}:G{$total}")->getFont()->setBold(true)->setSize(13);
    }

    public function registerEvents(): array
    {
        $sisaCuti   = 12;
        $data       = Cuti::where('id_user', $this->user)->whereBetween('cuti_awal', [$this->awl, $this->akh])->count();
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
        $set_user   = User::where('id', $this->user)->first();
        $nama_user  = $set_user->nama;
        $sisaCuti   = 12;
        $data       = Cuti::where('id_user', $this->user)->whereBetween('cuti_awal', [$this->awl, $this->akh])->get();

        return view('admin.laporan.expor_data.expor_cuti', [
            'data'      => $data,
            'user'      => $nama_user,
            'tawal'     => $this->awl,
            'takhir'    => $this->akh,
            'sisaCuti'  => $sisaCuti,
        ]);
    }
}
