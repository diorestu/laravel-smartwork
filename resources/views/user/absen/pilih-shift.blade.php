@extends('layouts.mobile')

@section('title')
    Pilih Shift Hari Ini
@endsection

@section('content')
    @php
    $id = Auth::user();
    $radius = 100;
    @endphp
    <section class="p-0 mb-3">
        <div class="py-4 px-4" style="background-color: #B0141C !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('absen.index') }}" class="text-white"><i data-feather="chevron-left"></i></a>
                </div>
                <div class="">
                    <h2 class="fw-bold font-size-18 text-white mb-0">Jadwal Kerja</h2>
                </div>
                <div class='py-3'>

                </div>
            </div>
        </div>
    </section>

    <div class="text-center">
        <div class="card rounded-sm mx-4">
            <div class="card-body px-3 py-8">
                <h4 class="text-center font-weight-bolder mb-3">Pilih Shift Hari Ini</h4>
                <form method="post" action="{{ route('user.post.shift') }}" id="myForm" class="px-3">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <label for="pilih_shift">Shift:</label>
                        <select name="shift" id="pilih_shift" class="form-select">
                            @foreach ($shift as $item)
                                <option value="{{ $item->id }}">{{ $item->ket_shift }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" id="btn" class="btn btn-primary rounded-sm w-100 py-3 mt-3">Update Jadwal</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@endsection
