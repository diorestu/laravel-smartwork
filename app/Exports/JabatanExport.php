<?php

namespace App\Exports;

use App\Models\Jabatan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class JabatanExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = Jabatan::where('id_admin', Auth::user()->id);
        return view('admin.jabatan.expor_data', [
            'data' => $data->get()
        ]);
    }
}
