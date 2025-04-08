<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form <span id="title-form"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="waktu" class="form-label">Pukul</label>
                            <input type="text" id="waktu" name="waktu" class="form-control" readonly>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="label" class="form-label">Note</label>
                            <textarea rows="5" class="form-control" name="note" id="note"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formMain').submit()" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>
        </div>
    </div>
</div>