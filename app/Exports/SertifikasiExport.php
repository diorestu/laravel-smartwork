<?php

namespace App\Exports;

use App\Models\Sertifikasi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class SertifikasiExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = Sertifikasi::where('id_admin', Auth::user()->id);
        return view('admin.sertifikasi.expor_data', [
            'data' => $data->get()
        ]);
    }
}
