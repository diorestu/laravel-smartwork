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
        // dd($rows);
        foreach ($rows as $row) {
            $total_kolom    = $row->count();
            // $nama_pegwai    = $row['nama_pegawai'];
            // $cabang         = $row['cabang'];
            $id_user        = $row['id'];
            $periode        = $row['periode'];
            $temp           = explode("/", $periode);
            $bulan          = sprintf("%02d", $temp[0]);
            $tahun          = $temp[1];

            for ($i=6; $i<=$total_kolom; $i++) {
                $kode_shift = $row[$i-5];
                $tanggal    = sprintf("%02d", $i-5);
                $date       = $tahun.'-'.$bulan.'-'.$tanggal;
                $shift      = Shift::where('id_admin', Auth::user()->id)->where('nama_shift', $kode_shift)->first();
                // proses tambah row ke table user_shifts
                UserShift::create([
                    'id_user'       => $id_user,
                    'id_user_shift' => $shift->id,
                    'tanggal_shift' => $date,
                    'status_shift'  => 'active',
                ]);
            }
        }
    }
}
