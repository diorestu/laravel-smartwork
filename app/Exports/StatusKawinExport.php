<?php

namespace App\Exports;

use App\Models\StatusKawin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class StatusKawinExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = StatusKawin::where('id_admin', Auth::user()->id);
        return view('admin.status_kawin.expor_data', [
            'data' => $data->get()
        ]);
    }
}
