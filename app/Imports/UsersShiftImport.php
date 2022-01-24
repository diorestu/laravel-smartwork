<?php

namespace App\Imports;

use App\Models\Shift;
use App\Models\UserShift;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersShiftImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $total = $row->count() - 2;
            for ($i=1; $i <= $total; $i++) {
                $tanggal = sprintf("%02d", $i);
                $date = date('Y-m-'.$tanggal);
                $shift = Shift::where('id_admin', Auth::user()->id)->where('nama_shift', $row[$i])->first();
                UserShift::create([
                    'id_user' => $row['id_user'],
                    'id_user_shift' => $shift->id,
                    'tanggal_shift' => $date,
                    'status_shift' => 'active',
                ]);
            }
        }
    }
}
