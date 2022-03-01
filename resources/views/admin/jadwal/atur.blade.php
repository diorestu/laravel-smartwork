@extends('layouts.main')

@section('title')
    Atur Jadwal Kerja Pegawai
@endsection

@push('addon-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/sl-1.3.1/datatables.min.css"/>
    <link href="{{ asset('backend-assets/libs/@fullcalendar/core/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/@fullcalendar/daygrid/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/@fullcalendar/bootstrap/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/libs/@fullcalendar/timegrid/main.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row px-0">
        <div class="col-12">
            <div class="page-title-box pb-2 d-sm-flex align-items-start justify-content-between">
                <div>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("cuti.index") }}">Jadwal Kerja</a></li>
                        <li class="breadcrumb-item active">Atur Jadwal Kerja Pegawai</li>
                    </ol>
                    <h4 class="mb-sm-0 fw-bold font-size-22 mt-3">Atur Jadwal Kerja Pegawai</h4>
                    <p class="text-muted mt-1 text-opacity-50">Atur data jadwal kerja pegawai</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div id="external-events" class="mt-2">
                        <h4>{{ $nama }}</h4>
                        <p class="text-muted">Drag lalu taruh shift yang tersedia di kolom kalendar untuk menambahkan shift.</p>
                        <br>
                        @php
                            $q_shift = App\Models\Shift::where('id_admin', auth()->user()->id)->get();
                        @endphp
                        @foreach ($q_shift as $r_shift)
                        <div class="external-event fc-event text-{{ $r_shift->warna_shift }} bg-soft-{{ $r_shift->warna_shift }}" data_id_shift="{{ $r_shift->id }}" data-class="bg-{{ $r_shift->warna_shift }}">
                            <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                            {{ $r_shift->nama_shift . " : ". $r_shift->ket_shift }}
                            @if ($r_shift->hadir_shift != null)
                            {{ "(". TampilJamMenit($r_shift->hadir_shift) . " - ". TampilJamMenit($r_shift->pulang_shift). ")" }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- Add New Event MODAL -->
    <div class="modal fade" id="event-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3 px-4 border-bottom-0">
                    <h5 class="modal-title" id="modal-title">Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation" name="event-form" id="form-event" novalidate>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Event Name</label>
                                    <input type="hidden" name="id_user_shift" id="id_user_shift" required value="" />
                                    <input class="form-control" placeholder="Insert Event Name" type="text" name="title" id="event-title" required value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" id="btn-delete-event">Hapus Shift</button>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" id="btn-save-event">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>
    <!-- end modal-->
@endsection


@push('addon-script')
    <script src="{{ asset('backend-assets/libs/@fullcalendar/core/main.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/@fullcalendar/bootstrap/main.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/@fullcalendar/daygrid/main.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/@fullcalendar/timegrid/main.min.js') }}"></script>
    <script src="{{ asset('backend-assets/libs/@fullcalendar/interaction/main.min.js') }}"></script>
    <!-- Calendar init -->
    {{-- <script src="{{ asset('backend-assets/js/pages/calendar.init.js') }}"></script> --}}
    <script type="text/javascript">
        ! function(v) {
        "use strict";

        function e() {}
        e.prototype.init = function() {
            var a = v("#event-modal"),
                t = v("#modal-title"),
                n = v("#form-event"),
                l = null,
                i = null,
                r = document.getElementsByClassName("needs-validation"),
                l = null,
                i = null,
                e = new Date,
                s = 1,
                d = {{ $bulan-1 }},
                e = {{ $tahun }};
            new FullCalendarInteraction.Draggable(document.getElementById("external-events"), {
                itemSelector: ".external-event",
                eventData: function(e) {
                    return {
                        title: e.innerText,
                        className: v(e).data("class")
                    }
                }
            });
            e = [
            @foreach ($data as $items){
                title: "{{ $items->nama_shift }} : {{ $items->ket_shift }}",
                deskripsi: "damas ganteng",
                id_user_shift: "{{ $items->id_shift }}",
                start: new Date(e, d, {{ TanggalOnly($items->tanggal_shift) }}, {{ JamOnly($items->hadir_shift) }}),
                end: new Date(e, d, {{ TanggalOnly($items->tanggal_shift) }}, {{ JamOnly($items->pulang_shift) }}),
                className: "bg-{{ $items->warna_shift }}"
            },
            @endforeach
            ], document.getElementById("external-events"), d = document.getElementById("calendar");

            function o(e) {
                a.modal("show"), n.removeClass("was-validated"), n[0].reset(), v("#event-title").val(), v("#event-category").val(), t.text("Add Event"), i = e
            }
            var c = new FullCalendar.Calendar(d, {
                plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                editable: !0,
                displayEventTime: false,
                droppable: !0,
                selectable: !0,
                defaultDate: "{{ $tahun }}-{{ tambahNol($bulan) }}-01",
                defaultView: "dayGridMonth",
                themeSystem: "bootstrap",
                header: {
                    left: "title"
                },
                eventClick: function(e) {
                    // alert(e.event.extendedProps.id_user_shift);
                    // console.log(e.event.extendedProps.deskripsi);
                    a.modal("show"), n[0].reset(), l = e.event, v("#id_user_shift").val(l.extendedProps.id_user_shift), v("#event-title").val(l.title), v("#event-category").val(l.classNames[0]), i = null, t.text("Edit Event"), i = null
                },
                dateClick: function(e) {
                    // o(e)
                },
                events: e,
                drop: function(e) {
                    var external_shift_v  = e.draggedEl.attributes[1].value;
                    var tanggal_shift_v   = e.dateStr;
                    var id_pegawai_v      = "{{ $user }}";
                    // alert(external_shift_v);
                    // console.log(e);
                    var url = "{{ url('kelola/jadwal/simpan') }}" + '/' + id_pegawai_v + '/' + external_shift_v + '/' + tanggal_shift_v;
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function(){
                            Swal.showLoading()
                        },
                        success: function(result)
                        {
                            // console.log(result.success);
                            if (result == "ok") {
                                Swal.fire('Berhasil', 'Berhasil menambah jadwal kerja pegawai', 'success')
                            } else {
                                Swal.fire('Gagal',result,'error')
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });
            c.render(), v(n).on("submit", function(e) {
                e.preventDefault();
                v("#form-event :input");
                var t               = v("#event-title").val(),
                    e               = v("#event-category").val(),
                    id_user_shift   = v("#id_user_shift").val();
                !1 === r[0].checkValidity() ? (event.preventDefault(), event.stopPropagation(), r[0].classList.add("was-validated")) : (l ? (l.setProp("title", t), l.setProp("classNames", [e])) : (e = {
                    title: t,
                    start: i.date,
                    allDay: i.allDay,
                    className: e
                }, c.addEvent(e)), a.modal("hide"))
            }), v("#btn-delete-event").on("click", function(e) {
                var t               = v("#event-title").val(),
                    e               = v("#event-category").val(),
                    id_user_shift   = v("#id_user_shift").val(),
                    url             = "{{ url('kelola/jadwal') }}" + '/' + id_user_shift;
                // alert(url);
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    beforeSend: function(){
                        Swal.showLoading()
                    },
                    success: function(result)
                    {
                        if (result == "ok") {
                            Swal.fire('Berhasil', 'Berhasil menghapus jadwal kerja pegawai', 'success')
                            l && (l.remove(), l = null, a.modal("hide"))
                        } else {
                            Swal.fire('Gagal',result,'error')
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }), v("#btn-new-event").on("click", function(e) {
                o({
                    date: new Date,
                    allDay: !0
                })
            })
        }, v.CalendarPage = new e, v.CalendarPage.Constructor = e
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.CalendarPage.init()
    }();
    </script>
    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire('Berhasil','{{ \Session::get('success') }}','success')
        </script>
    @endif
    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire('Gagal','{{ \Session::get('error') }}','error')
        </script>
    @endif
@endpush
