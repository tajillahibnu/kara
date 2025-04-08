<div class="card mb-6">
    <!-- Account -->
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-6">
            <img
                src="../../assets/img/avatars/1.png"
                alt="user-avatar"
                class="d-block w-px-100 h-px-100 rounded"
                id="uploadedAvatar" />
            <div class="button-wrapper">
                <div>
                    <h4 class="mb-0"><span class="detail-name"></span></h4>
                    <p><span class="detail-email"></span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-4">
        <form id="formAkunApp" action="javascript:onSaveIt('formAkunApp')" method="post">
            <input type="hidden" name="task" value="akun_app">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="lbl-name" class="form-label">Username</label>
                        <input class="form-control" type="text" id="username" name="username" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="lbl-email" class="form-label">Role Utama</label>
                        <input class="form-control" type="email" id="role_name" name="role_name" disabled/>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>
    <!-- /Account -->
</div>