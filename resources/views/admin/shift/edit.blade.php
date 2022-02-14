<style>
    .card-header, .modal-header { background: rgb(219,66,66); background: linear-gradient(90deg, rgba(219,66,66,1) 0%, rgba(126,7,30,1) 100%); }
</style>

<form action="{{ route('shift.update', $data->id) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Ubah Jam Kerja</h5>
    </div>
    <div class="modal-body p-4">
        <div data-scroll="true" data-height="400">
            <div class="row">
                <div class="col-6">
                    <div class="form-group mb-4">
                        <label for="nama_shift">Kode Shift <span class="text-danger">*</span></label>
                        <input required id="nama_shift" class="form-control" type="text" name="nama_shift" value="{{ $data->nama_shift }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="hadir_shift">Jam Hadir <span class="text-danger">*</span></label>
                        <input id="hadir_shift" class="form-control" type="time" name="hadir_shift" value="{{ $data->hadir_shift }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-4">
                        <label for="nama_shift">Nama Shift <span class="text-danger">*</span></label>
                        <input required id="nama_shift" class="form-control" type="text" name="ket_shift" value="{{ $data->ket_shift }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="pulang_shift">Jam Hadir <span class="text-danger">*</span></label>
                        <input id="pulang_shift" class="form-control" type="time" name="pulang_shift" value="{{ $data->pulang_shift }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block w-100 font-weight-bolder"><i class="fa fa-check icon-sm"></i> Ubah Jadwal Kerja</button>
    </div>
</form>
