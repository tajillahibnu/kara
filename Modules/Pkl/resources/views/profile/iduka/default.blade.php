<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<style>
    #map {
        height: 500px;
    }
</style>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header py-4 border-bottom">
                <h5 class="card-tile mb-0">Form Iduka</h5>
            </div>
            <div class="card-body">
                <form id="formIduka" class="mt-4" action="javascript:onSaveIt('formIduka')" method="post">
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Nama perusahaan</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="name" name="name" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Telpn</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="phone" name="phone" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Email</label>
                        <div class="col-7">
                            <input type="email" class="form-control" id="email" name="email" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Alamat</label>
                        <div class="col-7">
                            <textarea class="form-control" name="address" id="address" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header py-4 border-bottom">
                <h5 class="card-tile mb-0">Form PIC</h5>
            </div>
            <div class="card-body">
                <form id="fromPicIduka" class="mt-4" action="javascript:onSaveIt('fromPicIduka')" method="post">
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Nama PIC</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="pic_name" name="pic_name" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Jabtan PIC</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="pic_jabatan" name="pic_jabatan" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">No Tlpn PIC</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="pic_phone" name="pic_phone" />
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Username</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="username" name="username" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Password</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="password" name="password" />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-4 border-bottom">
                <h5 class="card-tile mb-0">Lokasi</h5>
            </div>
            <div class="card-body p-0">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>