<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserShift;
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

class JadwalExport implements FromView, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $cabang;
    protected $bulan;
    protected $tahun;

    public function __construct(int $cabang, string $bulan, string $tahun)
    {
        $this->cabang     = $cabang;
        $this->bulan      = $bulan;
        $this->tahun      = $tahun;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 40,
            'C' => 5,
            'D' => 5,
            'E' => 5,
            'F' => 5,
            'G' => 5,
            'H' => 5,
            'I' => 5,
            'J' => 5,
            'K' => 5,
            'L' => 5,
            'M' => 5,
            'N' => 5,
            'O' => 5,
            'P' => 5,
            'Q' => 5,
            'R' => 5,
            'S' => 5,
            'T' => 5,
            'U' => 5,
            'V' => 5,
            'W' => 5,
            'X' => 5,
            'Y' => 5,
            'Z' => 5,
            'AA' => 5,
            'AB' => 5,
            'AC' => 5,
            'AD' => 5,
            'AE' => 5,
            'AF' => 5,
            'AG' => 5,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Jadwal Shift Pegawai',
            'description'    => 'Jadwal Shift Pegawai',
            'subject'        => 'Jadwal Shift Pegawai',
            'keywords'       => 'jadwal kerja, shift pegawai',
            'category'       => 'Jadwal Shift Pegawai',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A3:AG3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:AG3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        if ($this->cabang != "all") {
            $data       = User::where('id_cabang', $this->cabang)->where('status', 'active')->count();
        } else {
            $data       = User::where('status', 'active')->count();
        }
        $jum        = $data + 3;
        $cellRange  = 'C4:AG' . $jum;
        $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        if ($this->cabang != "all") {
            $data       = User::where('id_cabang', $this->cabang)->where('status', 'active')->count();
        } else {
            $data       = User::where('status', 'active')->count();
        }
        $jum        = $data + 3;
        $cellRange  = 'A3:AG' . $jum;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:AG1');
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
        $id             = Auth::user()->id;
        if ($this->cabang != "all") {
            $data       = UserShift::select('users.nama', 'user_shifts.*', 'shifts.*', 'cabangs.cabang_nama')
                            ->join('shifts',        'user_shifts.id_user_shift',    '=', 'shifts.id')
                            ->join('users',         'users.id',                     '=', 'user_shifts.id_user')
                            ->join('cabangs',       'cabangs.id',                   '=', 'users.id_cabang')
                            ->where('users.id_admin', $id)
                            ->where('users.id_cabang', $this->cabang)
                            ->whereMonth('tanggal_shift', $this->bulan)
                            ->whereYear('tanggal_shift', $this->tahun);
        } else {
            $data       = UserShift::select('users.nama', 'user_shifts.*', 'shifts.*', 'cabangs.cabang_nama')
                            ->join('shifts',        'user_shifts.id_user_shift',    '=', 'shifts.id')
                            ->join('users',         'users.id',                     '=', 'user_shifts.id_user')
                            ->join('cabangs',       'cabangs.id',                   '=', 'users.id_cabang')
                            ->where('users.id_admin', $id)
                            ->whereMonth('tanggal_shift', $this->bulan)
                            ->whereYear('tanggal_shift', $this->tahun);
        }

        return view('admin.jadwal.expor_data.jadwal_ekspor', [
            'data'      => $data->get(),
            'cabang'    => $this->cabang,
            'bulan'     => $this->bulan,
            'tahun'     => $this->tahun,
        ]);
    }
}
