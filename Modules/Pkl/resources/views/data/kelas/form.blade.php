<div id="page-detail" class="row" style="display: none;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 info-name">Add a new Product</h4>
            <p class="mb-0 info-jurusan_name">Orders placed across your store</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <!-- <div class="d-flex gap-4">
                <button class="btn btn-label-secondary waves-effect">Discard</button>
                <button class="btn btn-label-primary waves-effect">Save draft</button>
            </div> -->
            <button type="button" onclick="onBack(this)" data-close="detail" data-open="main" class="btn btn-danger waves-effect waves-light">Back</button>
            <!-- <button type="submit" class="btn btn-primary waves-effect waves-light">Publish product</button> -->
        </div>
    </div>
    <div class="col-4">
        <div class="card mb-6">
            <div class="card-body">
                <small class="card-text text-uppercase text-muted small">Detail Kelas</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Nama:</span>
                        <span class="info-name">John Doe</span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ti ti-check ti-lg"></i><span class="fw-medium mx-2">Jurusan:</span>
                        <span class="info-jurusan_name">xx</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div id="page-main" class="card">
            <!-- <div class="card-header border-bottom">
                <h5 class="card-tile mb-0">Daftar Siswa</h5>
            </div> -->
            <div class="card-header d-flex justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5>Daftar Siswa</h5>
                </div>
                <div class="dropdown">
                    <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1 waves-effect waves-light" type="button" id="btnMore" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-md text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="btnMore">
                        <a class="dropdown-item waves-effect" href="javascript:modalEnrolSiswa();">Enrol Siswa</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Download</a>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tableSiswa" class="datatables-basic table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>JK</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>