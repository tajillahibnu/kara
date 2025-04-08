<style>
    .input-readonly {
        background-color: #f3f2f3;
        /* Warna latar belakang */
        color: #acaab1;
        /* Warna teks */
        pointer-events: none;
        /* Mencegah interaksi dengan elemen */
    }
</style>
<div class="card mb-6">
    <h5 class="card-header">Data Akademik</h5>
    <div class="card-body pt-4">
        <form id="frmBiodataSiswa" action="javascript:onSaveIt('frmBiodataSiswa')" method="post">
            <input type="hidden" name="task" value="biodata">
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Nomor Induk Siswa (NIS)</label>
                        <div class="col-7">
                            <input class="form-control input-readonly" type="text" id="nis" name="nis" readonly />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nisn" class="col-form-label col-5">Nomor Induk Siswa Nasional (NISN)</label>
                        <div class="col-7">
                            <input class="form-control input-readonly" type="text" id="nisn" name="nisn" readonly />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-rombel_name" class="col-form-label col-5">Kelas Saat Ini</label>
                        <div class="col-7">
                            <input class="form-control input-readonly" type="text" id="rombel_name" name="rombel_name" readonly />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-walikelas_name" class="col-form-label col-5">Wali Kelas</label>
                        <div class="col-7">
                            <input class="form-control input-readonly" type="text" id="walikelas_name" name="walikelas_name" readonly />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-jurusan_name" class="col-form-label col-5">Jurusan</label>
                        <div class="col-7">
                            <input class="form-control input-readonly" type="text" id="jurusan_name" name="jurusan_name" readonly />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-tahun_masuk" class="col-form-label col-5">Tahun masuk</label>
                        <div class="col-7">
                            <input class="form-control input-readonly" type="text" id="tahun_masuk" name="tahun_masuk" readonly />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-nis" class="col-form-label col-5">Status</label>
                        <div class="col-7 pt-2 detail-is_active">
                        </div>
                    </div>
                    <!-- <div class="row mb-4">
                        <label for="lbl-alamat" class="col-form-label col-5">Alamat</label>
                        <div class="col-7">
                            <textarea class="form-control" name="alamat" id="alamat" cols="4" rows="4"></textarea>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
            </div>
        </form>
    </div>
</div>