<div class="modal fade" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="mb-4">
                        <label for="kegiatan" class="form-label">Kegiatan</label>
                        <input type="text" id="kegiatan" name="kegiatan" class="form-control" placeholder="Enter Name" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="text" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="text" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="editorDeskripsi" class="form-label">Catatan</label>
                        <div id="editorDeskripsi" style="height: 400px;"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formMain').submit()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>