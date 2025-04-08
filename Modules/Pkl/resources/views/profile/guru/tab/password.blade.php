<style>
    .progress {
        width: 100%;
        background-color: #f3f3f3;
        border-radius: 5px;
        margin-top: 10px;
    }

    .progress-bar {
        width: 0;
        background-color: red;
        border-radius: 5px;
        transition: width 0.3s;
    }
</style>
<div class="card mb-6">
    <h5 class="card-header">Change Password</h5>
    <div class="card-body">
        <form id="formChangePassword" method="POST" action="javascript:onPassword('formChangePassword')" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <div class="alert alert-warning alert-dismissible py-3" role="alert">
                <h5 class="alert-heading mb-1">Pastikan bahwa persyaratan berikut dipenuhi</h5>
                <span>Minimal 8 karakter panjang, mengandung huruf kapital &amp; simbol</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="row">
                <div class="mb-sm-4 mb-6 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                    <label class="form-label" for="newPassword">New Password</label>
                    <div class="input-group input-group-merge has-validation">
                        <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="············">
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye ti-xs"></i></span>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar" id="progressBar"></div>
                    </div>
                    <div id="message"></div>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>

                <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                    <label class="form-label" for="confirmPassword">Confirm Password</label>
                    <div class="input-group input-group-merge has-validation">
                        <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="············">
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye ti-xs"></i></span>
                    </div>
                    <div id="message2"></div>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Change Password</button>
                </div>
            </div>
            <input type="hidden">
        </form>
    </div>
</div>