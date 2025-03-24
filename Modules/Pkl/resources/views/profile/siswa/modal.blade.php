<div class="modal fade show" id="biodataModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Biodata Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formBiodataSiswa" action="javascript:onSaveIt('formBiodataSiswa')" method="post">
                    <input type="hidden" name="task" value="biodata">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="border-bottom mt-2">Biodata</h5>
                            <div class="col-12 mb-4">
                                <label class="form-label" for="name">Nama Lengkap Siswa</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Nama Lengkap Siswa" required="">
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="lbl-tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input class="form-control" type="text" id="tempat_lahir" name="tempat_lahir" />
                                </div>
                                <div class="col-md-6">
                                    <label for="lbl-tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input class="form-control input-date" type="text" id="tanggal_lahir" name="tanggal_lahir" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="border-bottom mt-2">Kontak Person</h5>
                            <div class="col-12 mb-4">
                                <label class="form-label" for="no_wa">Nomor HP/WA</label>
                                <input class="form-control" id="no_wa" name="no_wa" type="text" placeholder="No Tlpn" required="">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="text" placeholder="No Tlpn" required="">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formBiodataSiswa').submit()" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Address Modal -->
<div class="modal fade show" id="addNewAddress" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="text-center">
                    <h4 class="address-title mb-0">Tambah Alamat Baru</h4>
                    <p class="address-subtitle">Silakan tambahkan alamat baru Anda</p>
                </div>
                <form id="addNewAddressForm" class="mt-6" action="javascript:onSaveItAlamat('addNewAddressForm')">
                    <input type="text" name="task" value="alamat">
                    <input type="text" id="taskIdAlamat" name="taskID" value="">
                    <div class="row mb-4">
                        <label for="lbl-label_alamat" class="col-form-label col-3">Label Alamat</label>
                        <div class="col-9">
                            <input class="form-control" type="text" id="label" name="label" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-form-label col-3" for="modalAddressAddress1">Alamat</label>
                        <div class="col-9">
                            <textarea class="form-control" name="alamat" id="alamat" cols="3" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-label_alamat" class="col-form-label col-3">Provinsi</label>
                        <div class="col-9">
                            <input class="form-control" type="text" id="provinsi" name="provinsi" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-label_alamat" class="col-form-label col-3">Kota</label>
                        <div class="col-9">
                            <input class="form-control" type="text" id="kota" name="kota" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-label_alamat" class="col-form-label col-3">Kecamatan</label>
                        <div class="col-9">
                            <input class="form-control" type="text" id="kecamatan" name="kecamatan" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-label_alamat" class="col-form-label col-3">Desa</label>
                        <div class="col-9">
                            <input class="form-control" type="text" id="desa" name="desa" />
                        </div>
                    </div>
                    <div class="row g-6">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="alamat_utama" name="alamat_utama" />
                                <label for="alamat_utama" class="form-label">Gunakan sebagai alamat utama?</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add New Address Modal -->