<div class="col-12">
    @php
        $sisaCuti = 12;
        $user   = App\Models\User::where('id_admin', auth()->user()->id)->where('id_cabang', $cabang)->pluck('id')->toArray();
        $q_cuti = App\Models\Cuti::groupBy('id_user')
                ->whereIn('id_user', $user)
                ->havingBetween('cuti_awal', [$tawal, $takhir])
                ->get();
    @endphp
    @forelse($q_cuti as $c)
    {{-- items --}}
    <div class="card shadow rounded-sm my-4">
        <div class="card-body">
            <div class="dropdown float-end">
                <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" style="">
                    <a class="dropdown-item" href="#">Ekspor ke Excel</a>
                    <a class="dropdown-item" href="#">Ekspor ke PDF</a>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <img src="{{ $c->user->company_logo == '' ? asset('backend-assets/images/no-staff.jpg') : asset('storage/uploads/'. $c->user->company_logo) }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                </div>
                <div class="flex-1 ms-3">
                    <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $c->user->nama }}</a></h5>
                    <p class="text-muted mb-0">{{ $c->user->divisi->div_title }}</p>
                </div>
            </div>
            <div class="d-flex mt-3 pt-1">
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                    {{ $c->user->phone }}</p>
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                    {{ $c->user->email }}</p>
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                    {{ $c->user->alamat }}</p>
                <p class="text-muted mb-0 mt-2 mx-3"><i class="mdi mdi-calendar font-size-15 align-middle pe-2 text-primary"></i>
                    Sisa cuti periode : {{ $sisaCuti }}</p>
            </div>
            <div class="table-responsive mt-4">
                <table class="table rounded" id="">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-left">Cuti Awal</th>
                            <th class="text-left">Cuti Akhir</th>
                            <th class="text-center">Hari Cuti</th>
                            <th class="text-center">Sisa Cuti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $q_isi = App\Models\Cuti::where('id_user', $c->id_user)
                                    ->whereBetween('cuti_awal', [$tawal, $takhir])
                                    ->get();
                            $ss_cuti = $sisaCuti;
                        @endphp
                        @foreach($q_isi as $d)
                        <tr>
                            <td>{{ tanggalIndo($d->cuti_awal) }}</td>
                            <td>{{ tanggalIndo($d->cuti_akhir) }}</td>
                            <td class="text-center">{{ $d->cuti_total }}h</td>
                            @php $ss_cuti = ($ss_cuti - $d->cuti_total) @endphp
                            <td class="text-center">{{ $ss_cuti }}h</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-end">Total Cuti :</th>
                            <th class="text-center">{{ $q_isi->sum('cuti_total') }}h</th>
                            <th class="text-center">{{ $ss_cuti }}h</th>
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
