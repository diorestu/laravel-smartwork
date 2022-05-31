@php
    if ($cabang != "all") {
        $dt_cb = App\Models\Cabang::where('id', $cabang)->get(); }
    else {
        $dt_cb = App\Models\Cabang::where('cabang_status', 'Active')->where('id_admin', Auth::user()->id)->get(); }
@endphp
@php $jum_hari = Carbon\Carbon::createFromFormat('m-Y', $bulan.'-'.$tahun)->daysInMonth; @endphp
@foreach ($dt_cb as $c)
<table>
    <thead>
        <tr><th>Jadwal Shift Pegawai Cabang {{ namaCabang($cabang) }} Periode {{ Bulan($bulan)." ".$tahun }}</th></tr>
        <tr><th></th></tr>
        <tr>
            <th>No.</th>
            <th>Nama Pegawai</th>
            @for ($i = 1; $i <= $jum_hari; $i++)
                <th>{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @php $nomor = 1;@endphp
        @foreach (App\Models\User::where('id_cabang', $c->id)->get() as $i)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $i->nama }}</td>
            @for ($j = 1; $j <= $jum_hari; $j++)
                @php
                    $id_user    = $i->id;
                    $ada        = false;
                    $data_shift = NULL;
                    foreach ($data as $item) {
                        $id_user_shift = $item->id_user;
                        $tanggal_shift = TanggalOnly($item->tanggal_shift);
                        if ($id_user_shift == $id_user && $j == $tanggal_shift) {
                            $ada        = true;
                            $data_shift = $item;
                        }
                    }
                @endphp
                @if ($ada)
                    <td>{{ $data_shift->shift->nama_shift }}</td>
                @else
                    <td>-</td>
                @endif
            @endfor
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><td></td></tr>
        <tr>
            <td></td>
            <td>Keterangan</td>
        </tr>
        @foreach (App\Models\Shift::where('id_admin', Auth::user()->id)->get() as $s)
        <tr>
            <td></td>
            <td></td>
            <td>{{ $s->nama_shift }} :</td>
            <td>{{ $s->ket_shift." (". $s->hadir_shift . " sd " . $s->pulang_shift .")" }} </td>
        </tr>
        @endforeach
    </tfoot>
</table>
@endforeach
