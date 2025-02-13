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
                            <label class="form-label" for="tingkat_id">Tingkat</label>
                            <select id="tingkat_id" name="tingkat_id" class="select2 form-select" data-placeholder="Select Tingkat"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="jurusan_id">Jurusan</label>
                            <select id="jurusan_id" name="jurusan_id" class="select2 form-select" data-placeholder="Select Tingkat"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="label" class="form-label">Label</label>
                            <input type="text" id="label" name="label" class="form-control" placeholder="Enter Name" required>
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