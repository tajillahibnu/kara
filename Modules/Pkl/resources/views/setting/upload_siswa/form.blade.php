<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:doSave('formMain')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="tahun_pelajaran">Tahun Pelajaran</label>
                            <select id="tahun_pelajaran" name="tahun_pelajaran" class="select2 form-select" data-placeholder="Select Tingkat"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="jurusan_id">Jurusan</label>
                            <select id="jurusan_id" name="jurusan_id" class="select2 form-select" data-placeholder="Select Tingkat"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="lbl-files_siswa" class="form-label">File Upload</label>
                            <input type="file" class="form-control" id="files_siswa" name="files_siswa">
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


<div class="modal fade show" id="modalKelasSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fromKelasSiswa" action="javascript:saveIt('fromKelasSiswa')" method="post">
                    <input type="hidden" name="taskSiswaID">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="kelas_siswa">Kelas</label>
                            <select id="kelas_siswa" name="kelas_siswa" class="select2 form-select" data-placeholder="Select Tingkat"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#fromKelasSiswa').submit()" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div>