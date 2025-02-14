<div id="page-main">
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-tile mb-0">Daftar Jurusan</h5>
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table id="maintable" class="datatables-basic table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Jurusan</th>
                        <th>Total</th>
                        <th>Diterima</th>
                        <th>Ditolak</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<div id="page-detail" style="display: none;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 info-kode">Add a new Product</h4>
            <p class="mb-0 info-name">Orders placed across your store</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                <!-- <button class="btn btn-label-secondary waves-effect">Discard</button> -->
                <!-- <button class="btn btn-label-primary waves-effect">Save draft</button> -->
            </div>
            <button type="button" onclick="onBack(this)" data-close="detail" data-open="main" class="btn btn-danger waves-effect waves-light">Back</button>
            <button type="button" onclick="registrasi_siswa()" class="btn btn-primary waves-effect waves-light">Registrasi</button>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0">Filter</h5>
                </div>
                <div class="card-body pt-2">
                    <div class="mb-6">
                        <label class="form-label" for="filter_priode">Priode PKL</label>
                        <select id="filter_priode" name="filter_priode" class="select2 form-select" data-placeholder="Select Priode"></select>
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="filter_tipe">Tipe</label>
                        <select id="filter_tipe" name="filter_tipe" class="select2 form-select" data-placeholder="Select Tipe">
                            <option selected value="all">Tampilkan Semua</option>
                            <option value="seleksi">Seleksi</option>
                            <option value="mandiri">Mandiri</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end border-top pt-2">
                        <div class="d-flex justify-content-end">
                            <button type="button" onclick="tableRegistrasi()" class="btn btn-primary waves-effect waves-light">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-tile mb-0">Daftar Registrasi</h5>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table id="table-registrasi" class="datatables-basic table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pkl::pkl.pendaftaran.form')