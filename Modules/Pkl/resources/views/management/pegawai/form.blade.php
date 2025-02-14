<div class="modal fade show" id="mainModal" tabindex="-1" role="dialog">
    <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="name" class="form-label">Nama Lengkap Pegawai</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="demo@educare.com" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="email" class="form-label">Roles</label>
                            <select id="select_roles" name="select_roles" multiple class="select2 form-select" data-placeholder="Select Roles">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>