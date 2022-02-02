<?php

namespace App\Charts;

use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UserCountChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $id     = Auth::user()->id;
        $hasil = array();
        // $cabang_nama = Cabang::where('id_admin', $id)->orderBy('id')->pluck('cabang_nama')->toArray();
        $cabang = Cabang::where('id_admin', $id)->orderBy('id');
        foreach ($cabang->pluck('id')->toArray() as $i) {
            $user   = User::select('id')
            ->where('id_cabang', $i)->where('id_admin', $id)
            ->count();
            array_push($hasil, $user);
        }
        // dd($hasil);
        return $this->chart->barChart()
            ->setTitle('Keaktifan Pengguna')
            ->addData('Jumlah Pengguna', $hasil)
            ->addData('Keaktifan Pengguna   ', $hasil)
            ->setFontFamily('Be Vietnam Pro')
            ->setGrid(false, '#3F51B5', 0.1)
            // ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            // ->setYAxis([0, 100, 200, 300])
            ->setXAxis($cabang->pluck('cabang_nama')->toArray());
    }
}
