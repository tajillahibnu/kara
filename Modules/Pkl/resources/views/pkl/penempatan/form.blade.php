<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="mb-4">
                        <label class="form-label" for="dudi_id">Lokasi Industri</label>
                        <select id="dudi_id" name="dudi_id" class="select2 form-select" data-placeholder="Select Industri"></select>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="tanggal_mulai">Tanggal Mulai</label>
                            <input class="form-control form-date" id="tanggal_mulai" name="tanggal_mulai" type="text" required="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tanggal_berakhir">Tanggal Berakhir</label>
                            <input class="form-control form-date" id="tanggal_berakhir" name="tanggal_berakhir" type="text" required="">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="pegawai_id">Guru Pendamping</label>
                        <select id="pegawai_id" name="pegawai_id" class="select2 form-select" data-placeholder="Select Pendamping"></select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="name">Nama Pembina</label>
                        <input class="form-control" id="pembina_name" name="pembina_name" type="text" required="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="name">Jabatan Pembina</label>
                        <input class="form-control" id="pembina_jabatan" name="pembina_jabatan" type="text" required="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="name">Telp Pembina</label>
                        <input class="form-control" id="pembina_hp" name="pembina_hp" type="text" required="">
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