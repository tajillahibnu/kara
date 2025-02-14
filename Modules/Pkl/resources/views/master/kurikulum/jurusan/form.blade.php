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
                            <label class="form-label" for="kode">Kode</label>
                            <input class="form-control" id="kode" name="kode" type="text" placeholder="Nama Jurusan" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Nama Jurusan</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Nama Jurusan" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="bidang_keahlian">Bidang Keahlian</label>
                            <input class="form-control" id="bidang_keahlian" name="bidang_keahlian" type="text" placeholder="Nama Jurusan" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="program_keahlian">Program Keahlian</label>
                            <input class="form-control" id="program_keahlian" name="program_keahlian" type="text" placeholder="Nama Jurusan" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
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