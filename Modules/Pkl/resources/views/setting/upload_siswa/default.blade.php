<div id="page-main">
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <h5 class="card-tile mb-0">Daftar File Upload</h5>
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table id="maintable" class="datatables-basic table">
                <thead>
                    <tr>
                        <th></th>
                        <th>File</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="page-detail" style="display: none;">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between border-bottom">
            <div class="card-title m-0 me-2">
                <h5 class="mb-1">Detail <span class="info-filename"></span></h5>
            </div>
            <div class="dropdown">
                <button type="button" onclick="onBack()" class="btn btn-danger waves-effect waves-light">Back</button>
            </div>
        </div>
        <div class="card-body pt-4">
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="row mb-4">
                        <label for="lbl-filename" class="col-md-4 col-form-label">Nama File</label>
                        <div class="col-md-8">
                            <input type="text" id="filename" name="filename" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-row_count" class="col-md-4 col-form-label">Total Siswa</label>
                        <div class="col-md-8">
                            <input type="text" id="row_count" name="row_count" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4">
                        <label for="lbl-jurusan_name" class="col-md-4 col-form-label">Jurusan</label>
                        <div class="col-md-8">
                            <input type="text" id="jurusan_name" name="jurusan_name" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="lbl-status" class="col-md-4 col-form-label">Status</label>
                        <div class="col-md-8">
                            <input type="text" id="status" name="status" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="card mb-4">
        <div class="card-header border-bottom">
            <h5 class="card-tile mb-0">Log Error</h5>
        </div>
        <div class="card-datatable table-responsive pt-0">
            <div id="box-table-log"></div>
        </div>
    </div> -->

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-tile mb-0">Daftar Siswa</h5>
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table id="table-siswa" class="datatables-basic table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Tingkat</th>
                        <th>Rombel</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('pkl::setting.upload_siswa.form')