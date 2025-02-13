<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Application</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form id="frmSekolah" class="row g-3" action="javascript:onSaveApp('frmSekolah')" method="post">
                    <div class="mb-6">
                        <label class="form-label" for="app_title">Nama Singkat Aplikasi</label>
                        <input class="form-control" id="app_title" name="app_title" type="text" placeholder="Nama Singkat Aplikasi" required="">
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="app_name">Nama Applikasi</label>
                        <input class="form-control" id="app_name" name="app_name" type="text" placeholder="Nama Aplikasi" required="">
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="app_deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="app_deskripsi" name="app_deskripsi" cols="30" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">SMTP Email</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form id="frmEmail" class="row g-3" action="javascript:onSaveApp('frmEmail')" method="post">
                    <div class="mb-6">
                        <label class="form-label" for="email_address">Alamat Email</label>
                        <input class="form-control" id="email_address" name="email_address" type="email" placeholder="Alamat Email" required="">
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="email_name">Nama Email</label>
                        <input class="form-control" id="email_name" name="email_name" type="text" placeholder="Nama Email" required="">
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="email_port">Port Email</label>
                        <input class="form-control" id="email_port" name="email_port" type="text" placeholder="Port Email" required="">
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="email_username">User Name</label>
                        <input class="form-control" id="email_username" name="email_username" type="text" placeholder="No NPSN" required="">
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="email_password">Password</label>
                        <input class="form-control" id="email_password" name="email_password" type="text" placeholder="No NPSN" required="">
                    </div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>