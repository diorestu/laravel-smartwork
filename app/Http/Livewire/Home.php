<?php

namespace App\Http\Livewire;

use App\Models\Cuti;
use App\Models\Absensi;
use App\Models\Pengumuman;
use Livewire\Component;
use App\Models\UserShift;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $data;

    public function render()
    {
        $id_admin       = Auth::user()->id_admin;
        $id_divisi      = Auth::user()->id_divisi;
        $pengumuman     = Pengumuman::where('id_admin', $id_admin)
                        ->where('id_divisi', $id_divisi)
                        ->orWhere('id_divisi', '0')
                        ->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('m'))
                        ->orderBy('created_at', 'DESC')->take(5)->get();
        return view('livewire.home', [
            'id'                => Auth::user(),
            'data_pengumuman'   => $pengumuman,
        ]);
    }

    public function mount()
    {
        $this->data = Auth::user();
    }
}
