<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-12 mb-4">
                                <label class="form-label" for="jurusan_id">Jurusan</label>
                                <select id="jurusan_id" name="jurusan_id" class="select2 form-select" data-placeholder="Select Jurusan"></select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="name">Nama Perusahaan</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Nama Perusahaan" required="">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="name">Email</label>
                                <input class="form-control" id="email" name="email" type="email" required="">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="phone">Phone</label>
                                <input class="form-control" id="phone" name="phone" type="text" required="">
                            </div>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="pic_jabatan">Username</label>
                                        <input class="form-control" id="username" name="username" type="text" placeholder="Username" required="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="password">Password</label>
                                        <input class="form-control" id="password" name="password" type="text" placeholder="Password" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label" for="pic_name">Nama Pembimbing</label>
                                <input class="form-control" id="pic_name" name="pic_name" type="text" placeholder="Nama Pembimbing" required="">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="pic_jabatan">Jabatan Pembimbing</label>
                                <input class="form-control" id="pic_jabatan" name="pic_jabatan" type="text" placeholder="Jabatan Pembimbing" required="">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="kota">Kota</label>
                                <input class="form-control" id="kota" name="kota" type="text" placeholder="Kota Lokasi Industri" required="">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="address">Alamat</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div id="map" style="height: 400px;"></div>
                            <div class="row mt-4">
                                <div class="col-6">
                                    <label class="form-label" for="latitude">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" required="">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="longitude">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" required="">
                                </div>
                            </div>
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