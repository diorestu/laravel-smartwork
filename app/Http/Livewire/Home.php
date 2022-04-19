<?php

namespace App\Http\Livewire;

use App\Models\Cuti;
use App\Models\Absensi;
use Livewire\Component;
use App\Models\UserShift;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $data;

    public function render()
    {
        $id        = Auth::user()->id;
        $shift     = UserShift::where('id_user', $id)->whereDate('tanggal_shift', date('Y-m-d'))->first();
        $absen     = Absensi::whereDate('jam_hadir', date('Y-m-d'))->where('id_user', $id)->first();
        $absenLast = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->first();
        $riwayat   = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->take(5)->get();
        $cuti      = Cuti::leftJoin('cuti_jenis', function ($join) {
                        $join->on('cutis.id_cuti_jenis', '=', 'cuti_jenis.id');
                    })->where('cutis.id_user', $id)->where('cutis.cuti_status', 'DITERIMA')->sum('cuti_total');
        $sakit      = Cuti::leftJoin('cuti_jenis', function ($join) {
            $join->on('cutis.id_cuti_jenis', '=', 'cuti_jenis.id');
        })->where('cutis.id_user', $id)->where('cuti_jenis.cuti_nama_jenis', 'LIKE', '%' . 'Sakit' . '%')->where('cutis.cuti_status', 'DITERIMA')->sum('cuti_total');
        $title     = null;
        $d         = false;
        if (!$shift) {
            $title = 'Absen Tidak Tersedia';
            $d = true;
        } elseif ($shift->shift->ket_shift == 'Libur' || $shift->shift->hadir_shift == null) {
            $title = 'Tidak Ada Shift';
            $d = true;
        }

        return view('livewire.home', [
            'absen'   => $absen,
            'riwayat' => $riwayat,
            'cuti'    => $cuti,
            'sakit'   => $sakit,
            'terbaru' => $absenLast,
            'shift'   => $shift,
            'id'      => Auth::user(),
            'd'       => $d,
            'title'   => $title
        ]);
    }

    public function mount()
    {
        $this->data = Auth::user();
    }
}
