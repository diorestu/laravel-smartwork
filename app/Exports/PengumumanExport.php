<?php

namespace App\Exports;

use App\Models\Pengumuman;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PengumumanExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = Pengumuman::where('id_admin', Auth::user()->id);
        return view('admin.pengumuman.expor_data', [
            'data' => $data->get()
        ]);
    }
}
