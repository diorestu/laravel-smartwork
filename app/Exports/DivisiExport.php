<?php

namespace App\Exports;

use App\Models\Divisi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class DivisiExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = Divisi::where('id_admin', Auth::user()->id);
        return view('admin.divisi.expor_data', [
            'data' => $data->get()
        ]);
    }
}
