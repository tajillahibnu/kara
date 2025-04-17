<!-- Hour chart  -->
<div class="card bg-transparent shadow-none my-6 border-0">
    <div class="card-body row p-0 pb-6 g-6">
        <div class="col-12 col-lg-5 ps-md-4 ps-lg-6 card-separator">
            <div class="d-flex justify-content-between align-items-center">
                <div id="title-date"></div>
                <div id="btnAction"></div>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
                <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
                    <div class="avatar avatar-lg">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="ti ti-transfer-in fs-large"></i>
                        </div>
                    </div>
                    <div class="content-right">
                        <p class="mb-0 fw-medium">Clock In</p>
                        <h4 class="text-primary mb-0"><span class="info-clock_in_real"">0</span></h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar avatar-lg">
                        <div class="avatar-initial bg-label-info rounded">
                            <i class="ti ti-transfer-out fs-large"></i>
                        </div>
                    </div>
                    <div class="content-right">
                        <p class="mb-0 fw-medium">Clock Out</p>
                        <h4 class="text-info mb-0"><span class="info-clock_out_real"">0</span></h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar avatar-lg">
                        <div class="avatar-initial bg-label-warning rounded">
                            <i class="ti ti-clock-24 fs-large"></i>
                        </div>
                    </div>
                    <div class="content-right">
                        <p class="mb-0 fw-medium">Hours</p>
                        <h4 class="text-warning mb-0"><span class="info-durasi_real"">0</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hour chart End  -->
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-tile mb-0">Daftar Absensi</h5>
    </div>
    <div class="card-datatable table-responsive pt-0">
        <table id="maintable" class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Durasi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('pkl::absensi.pkl.harian.siswa.form')