@extends('layouts.mobile')

@section('title')Pilih Shift | Smartwork @endsection

@section('content')
    @php $id = Auth::user(); @endphp
    <section class="">
        <div class="ps-5 pe-4" style="background-color: #B0141C !important; height:135px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:void(0);" onclick="history.back()" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div>
                    <h2 class="fw-bold font-size-18 text-white mb-0">Jadwal Kerja</h2>
                </div>
                <div>
                    <button type="button" class="btn header-item mx-0 px-0" id="mode-setting-btn">
                        <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                        <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                    </button>
                </div>
            </div>
            <div class="text-center mt-3">
                <h2 id='span' class="text-center text-white fw-light mb-0 display-4"></h2>
                <span class="text-white mt-0">Pilih jadwal hari ini, {{ Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, LL') }}</span>
            </div>
        </div>
    </section>
    <main class="px-4 parent pb-0 mt-3">
        <div class="child card rounded-md mb-0 px-0">
            <div class="card-body p-2">
                <div class="row">
                    <form method="post" action="{{ route('user.post.shift') }}" id="myForm" class="px-3">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <select name="shift" id="pilih_shift" class="form-select">
                                @foreach ($shift as $item)
                                    <option value="{{ $item->id }}">{{ $item->ket_shift }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="btn" class="btn btn-primary w-100 py-2 mt-2">Update Jadwal</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
