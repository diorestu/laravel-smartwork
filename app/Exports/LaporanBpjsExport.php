<?php

namespace App\Exports;

use App\Models\Payroll;
use App\Models\PayrollParent;
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

class LaporanBpjsExport implements FromView, WithColumnFormatting, WithEvents, WithProperties, WithStyles, WithColumnWidths, Responsable
{
    use Exportable, RegistersEventListeners;

    protected $tipe;
    protected $id_cabang;
    protected $period_bulan;
    protected $period_tahun;

    public function __construct(string $tipe, int $id_cabang, int $period_bulan, int $period_tahun)
    {
        $this->tipe_bpjs = $tipe;
        $this->cabang    = $id_cabang;
        $this->bl        = $period_bulan;
        $this->th        = $period_tahun;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 40,
            'C' => 19,
            'D' => 19,
            'E' => 19,
            'F' => 19,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            'D' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            'E' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            'F' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'PT. Asta Pijar Kreasi Teknologi',
            'lastModifiedBy' => 'PT. Asta Pijar Kreasi Teknologi',
            'title'          => 'Laporan Iuran BPJS Pegawai',
            'description'    => 'Laporan Iuran BPJS Pegawai',
            'subject'        => 'Laporan Iuran BPJS Pegawai',
            'keywords'       => 'bpjs, iuran bulanan bpjs',
            'category'       => 'Laporan Iuran BPJS',
            'manager'        => 'Damasius Wikaryana Utama',
            'company'        => 'Smartwork App',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A3:F3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('C3:F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        $id_admin   = Auth::user()->id_admin;
        $user       = User::where('id_admin', $id_admin)->where('id_cabang', $this->cabang)->pluck('id')->toArray();
        $payroll    = PayrollParent::where('pay_bulan', $this->bl)
            ->where('pay_tahun', $this->th)
            ->where('id_admin', $id_admin)
            ->pluck('id')->toArray();
        $data       = Payroll::whereIn('id_payroll', $payroll)->whereIn('id_user', $user)->count();
        $jum        = $data + 3;
        $cellRange  = 'A3:F'.$jum;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->mergeCells('A1:F1');
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
        $id_admin   = Auth::user()->id_admin;
        $user       = User::where('id_admin', $id_admin)->where('id_cabang', $this->cabang)->pluck('id')->toArray();
        $payroll    = PayrollParent::where('pay_bulan', $this->bl)
                                    ->where('pay_tahun', $this->th)
                                    ->where('id_admin', $id_admin)
                                    ->pluck('id')->toArray();
        $data       = Payroll::whereIn('id_payroll', $payroll)->whereIn('id_user', $user)->get();

        return view('admin.laporan.expor_data.expor_bpjs', [
            'data' => $data,
            'tipe' => $this->tipe_bpjs,
        ]);
    }
}
