<?php

namespace App\Exports;

use App\Models\MasaKerja;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MasaKerjaExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = MasaKerja::where('id_admin', Auth::user()->id);
        return view('admin.masa_kerja.expor_data', [
            'data' => $data->get()
        ]);
    }
}
