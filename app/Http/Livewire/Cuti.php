<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Cuti extends Component
{
    public function render()
    {
        $id = Auth::user()->id;
        $cuti      = Cuti::leftJoin('cuti_jenis', function ($join) {
            $join->on('cutis.id_cuti_jenis', '=', 'cuti_jenis.id');
        })->where('cutis.id_user', $id)->where('cutis.cuti_status', 'DITERIMA')->sum('cuti_total');
        $sakit      = Cuti::leftJoin('cuti_jenis', function ($join) {
            $join->on('cutis.id_cuti_jenis', '=', 'cuti_jenis.id');
        })->where('cutis.id_user', $id)->where('cuti_jenis.cuti_nama_jenis', 'LIKE', '%' . 'Sakit' . '%')->where('cutis.cuti_status', 'DITERIMA')->sum('cuti_total');
        return view('livewire.cuti');
    }
}
