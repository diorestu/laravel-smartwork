@extends('layouts.mobile')

@section('content')
<div class="py-10 px-8 bg-white" id="kt_content">
    <div class="d-flex justify-content-between">
        <h5 class='font-size-h1 font-weight-boldest'>Hi, {{ auth()->user()->nama }}</h5>
    </div>
</div>

@endsection
