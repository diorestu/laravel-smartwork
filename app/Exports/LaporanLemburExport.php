<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Lembur;
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

class LaporanLemburExport implements FromView, WithColumnFormatting, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
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
            'title'          => 'Laporan Lembur Pegawai',
            'description'    => 'Laporan Lembur Pegawai',
            'subject'        => 'Laporan Lembur Pegawai',
            'keywords'       => 'lembur, perhitungan lembur',
            'category'       => 'Laporan Lembur Pegawai',
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

        $data_absen = Absensi::where('id_user', $this->user)
            ->whereBetween('jam_pulang', [$this->awl, $this->akh])
            ->whereNotNull('jam_lembur')
            ->count();

        $data_lembur = Lembur::where('id_user', $this->user)
            ->where('lembur_status', 'DITERIMA')
            ->whereBetween('lembur_awal', [$this->awl, $this->akh])
            ->count();
        $total      = $data_absen + $data_lembur;

        $jum        = $total + 3;
        $sum        = $jum + 1;
        $sheet->setCellValue("G{$sum}", "=SUM(G4:G{$jum})");
        $sheet->setCellValue("H{$sum}", "=SUM(H4:H{$jum})");
        $sheet->getStyle("F{$sum}:H{$sum}")->getFont()->setBold(true)->setSize(13);
    }

    public function registerEvents(): array
    {
        $data_absen = Absensi::where('id_user', $this->user)
            ->whereBetween('jam_pulang', [$this->awl, $this->akh])
            ->whereNotNull('jam_lembur')
            ->count();

        $data_lembur = Lembur::where('id_user', $this->user)
            ->where('lembur_status', 'DITERIMA')
            ->whereBetween('lembur_awal', [$this->awl, $this->akh])
            ->count();
        $total      = $data_absen+$data_lembur;
        $jum        = $total + 3;
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
        $data_absen = Absensi::where('id_user', $this->user)
                        ->whereBetween('jam_pulang', [$this->awl, $this->akh])
                        ->whereNotNull('jam_lembur')
                        ->get();

        $data_lembur = Lembur::where('id_user', $this->user)
                        ->where('lembur_status', 'DITERIMA')
                        ->whereBetween('lembur_awal', [$this->awl, $this->akh])
                        ->get();

        return view('admin.laporan.expor_data.expor_lembur', [
            'data_absen'    => $data_absen,
            'data_lembur'   => $data_lembur,
            'user'          => $nama_user,
            'tawal'         => $this->awl,
            'takhir'        => $this->akh,
        ]);
    }
}
