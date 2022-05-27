<?php

namespace App\Exports;

use App\Models\Absensi;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiPegawai implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
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
            'E' => 14,
            'F' => 8,
            'G' => 32,
            'H' => 11,
            'I' => 11,
            'J' => 14,
            'K' => 8,
            'L' => 32,
            'M' => 11,
            'N' => 11,
            'O' => 11,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Rekap Absensi Pegawai per Pegawai',
            'description'    => 'Rekap Absensi Pegawai per Pegawai',
            'subject'        => 'Rekap Absensi Pegawai per Pegawai',
            'keywords'       => 'absensi, absensi per pegawai',
            'category'       => 'Rekap Absensi Pegawai per Pegawai',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:O4')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A3:O4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        $id     = Auth::user()->id_admin;
        $data   = Absensi::select(['absensis.id', 'cabang_nama', 'absensis.id_user', 'jam_hadir', 'jam_pulang', 'jam_kerja',])
                            ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                            ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                            ->whereBetween('absensis.jam_hadir',                [$this->awal, $this->akhir])
                            ->where('absensis.id_user',                         $this->user)
                            ->where('users.id_admin', $id)->count();
        $jum        = $data + 4;
        $cellRange  = 'A3:O' . $jum;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:O1');
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
        $data   = Absensi::select(['absensis.id', 'cabang_nama', 'absensis.id_user', 'jam_hadir', 'jam_pulang', 'jam_kerja',])
                            ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                            ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                            ->whereBetween('absensis.jam_hadir',                [$this->awal, $this->akhir])
                            ->where('absensis.id_user',                         $this->user)
                            ->where('users.id_admin', $id)->get();

        return view('admin.absensi.expor_data.pegawai_absen', [
            'data'      => $data,
            'user'      => $this->user,
            'awal'      => $this->awal,
            'akhir'     => $this->akhir,
        ]);
    }
}
