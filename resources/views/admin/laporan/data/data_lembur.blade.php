<div class="col-12">
    @php
        $user       = App\Models\User::where('id_admin', auth()->user()->id)->where('id_cabang', $cabang)->get();
        // $q_lembur   = App\Models\Lembur::groupBy('id_user')
        //             ->whereIn('id_user', $user)
        //             ->where('lembur_status', 'DITERIMA')
        //             ->havingBetween('lembur_awal', [$tawal, $takhir])
        //             ->get();
        // //
        // $q_absen    = App\Models\Absensi::groupBy('id_user')
        //             ->whereIn('id_user', $user)
        //             ->whereBetween('jam_pulang', [$tawal, $takhir])
        //             ->whereNotNull('jam_lembur')
        //             ->get();
        // if ($q_lembur->isEmpty()) { $q_damas = $q_absen; } else { $q_damas = $q_lembur; }
    @endphp
    @forelse($user as $c)
    {{-- items --}}
    <div class="card shadow rounded-sm my-4">
        <div class="card-body">
            <div class="dropdown float-end">
                <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" style="">
                    <a class="dropdown-item" href="{{ route("lapLembur.ekspor", ['u'=>$c->id, 's'=>$tawal, 'e'=>$takhir]) }}">Ekspor ke Excel</a>
                    <a class="dropdown-item" href="#">Ekspor ke PDF</a>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <img src="{{ $c->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $c->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                </div>
                <div class="flex-1 ms-3">
                    <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $c->nama }}</a></h5>
                    <p class="text-muted mb-0">{{ $c->divisi->div_title }}</p>
                </div>
            </div>
            <div class="d-flex mt-3 pt-1">
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                    {{ $c->phone }}</p>
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                    {{ $c->email }}</p>
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                    {{ $c->alamat }}</p>
            </div>
            <div class="table-responsive mt-4">
                <table class="table rounded" id="">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-left">Lembur Awal</th>
                            <th class="text-left">Lembur Akhir</th>
                            <th class="text-left">Ket.</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Jam Kerja</th>
                            <th class="text-center">Jam Lembur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $q_isi_absen = App\Models\Absensi::where('id_user', $c->id)
                                    ->whereBetween('jam_pulang', [$tawal, $takhir])
                                    ->whereNotNull('jam_lembur')
                                    ->get();
                        @endphp
                        @foreach($q_isi_absen as $a)
                        <tr>
                            <td>{{ tanggalIndoWaktu2($a->jam_hadir) }}</td>
                            <td>{{ tanggalIndoWaktu2($a->jam_pulang) }}</td>
                            <td class="text-left"></td>
                            <td class="text-center">Absensi</td>
                            <td class="text-center">{{ $a->jam_kerja }} jam</td>
                            <td class="text-center">{{ $a->jam_lembur }} jam</td>
                        </tr>
                        @endforeach
                        @php
                            $q_isi = App\Models\Lembur::where('id_user', $c->id)
                                    ->where('lembur_status', 'DITERIMA')
                                    ->whereBetween('lembur_awal', [$tawal, $takhir])
                                    ->get();
                        @endphp
                        @foreach($q_isi as $d)
                        <tr>
                            <td>{{ tanggalIndoWaktu2($d->lembur_awal) }}</td>
                            <td>{{ tanggalIndoWaktu2($d->lembur_akhir) }}</td>
                            <td class="text-left">{{ $d->lembur_judul }}</td>
                            <td class="text-center">Pengajuan</td>
                            <td class="text-center">{{ $d->jam_kerja }} jam</td>
                            <td class="text-center">{{ $d->jam_lembur }} jam</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total Lembur :</th>
                            <th class="text-center"></th>
                            <th class="text-center">{{ $q_isi_absen->sum('jam_lembur') + $q_isi->sum('jam_lembur') }} jam</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total Upah Lembur :</th>
                            <th class="text-center"></th>
                            <th class="text-center">Rp. 200.000</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    {{-- end items --}}
    @empty
    <div class="col-12">
        <div class="card card-custom gutter-b rounded-sm shadow-sm">
            <div class="card-body p-4">
                <div class="text-center">
                    <h1><i class="fas fa-ban"></i></h1>
                    <h4>Tidak Ada Data</h4>
                    <p>Maaf, data yang Anda cari tidak tersedia</p>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>
