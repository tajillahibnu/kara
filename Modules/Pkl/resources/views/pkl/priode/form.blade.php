<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Priode PKL</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Nama Lengkap Siswa" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="tahun_ajaran">Tahun Pelajaran</label>
                            <select id="tahun_ajaran" name="tahun_ajaran" class="select2 form-select" data-placeholder="Select Tahun"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Batas Registrasi</label>
                            <input class="form-control" id="batas_registrasi" name="batas_registrasi" type="text" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Kuota Siswa</label>
                            <input class="form-control" id="kuota_siswa" name="kuota_siswa" type="text" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="name">Tanggal Mulai</label>
                                    <input class="form-control" id="tanggal_mulai" name="tanggal_mulai" type="text" required="">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="name">Tanggal Selesai</label>
                                    <input class="form-control" id="tanggal_selesai" name="tanggal_selesai" type="text" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Note Pengumuman</label>
                            <textarea class="form-control" name="syarat_pendaftaran" id="syarat_pendaftaran" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formMain').submit()" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div>