<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:saveItRegister('formMain')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="periode_id">Priode PKL</label>
                            <select id="periode_id" name="periode_id" class="select2 form-select" data-placeholder="Select Priode"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="filter_tingkat">Tingkat</label>
                            <select id="filter_tingkat" name="filter_tingkat" onchange="comboSiswa()" class="select2 form-select" data-placeholder="Select Tingkat"></select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="siswa_id">Siswa</label>
                            <select id="siswa_id" name="siswa_id[]" class="select2 form-select" multiple data-placeholder="Select Siswa" required></select>
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