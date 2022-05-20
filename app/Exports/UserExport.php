<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class UserExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data       = User::where('id_admin', Auth::user()->id)->where('is_admin', 0);
        return view('admin.staff.expor_data', [
            'data' => $data->get()
        ]);
    }
}
