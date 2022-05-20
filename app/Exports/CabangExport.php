<?php

namespace App\Exports;

use App\Models\Cabang;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class CabangExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = Cabang::where('id_admin', Auth::user()->id);
        return view('admin.cabang.expor_data', [
            'data' => $data->get()
        ]);
    }
}
