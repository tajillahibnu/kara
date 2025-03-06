<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-7">
                    <div class="card-body text-nowrap">
                        <h5 class="mb-0">Welcome back,</h5>
                        <span class="h4 mt-0"> {{Auth::user()->name}} </span>
                        <!-- <p class="mb-2">{{ session('active_role_name'); }}</p> -->
                        <!-- <h4 class="text-primary mb-1">$48.9k</h4> -->
                        <!-- <a href="javascript:;" class="btn btn-primary waves-effect waves-light">View Sales</a> -->
                    </div>
                </div>
                <div class="col-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="../../assets/img/illustrations/card-advance-sale.png" height="140" alt="view sales">
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-border-shadow-primary my-2">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-school ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0"><span class="info-totalPegawai"></span> Pegawai</h4>
                </div>
                <p class="mb-1">Total Seluruh Pegawai</p>
            </div>
        </div>
        <div class="card card-border-shadow-primary my-2">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-users ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0"><span class="info-totalSiswa"></span> Siswa</h4>
                </div>
                <p class="mb-1">Total Seluruh Siswa</p>
            </div>
        </div>
        <div class="card card-border-shadow-primary my-2">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-books ti-28px"></i></span>
                    </div>
                    <h4 class="mb-0"><span class="info-totalRombel"></span> Kelas</h4>
                </div>
                <p class="mb-1">Total Seluruh Kelas</p>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Grafik Siswa Jurusan</h5>
            </div>
            <div class="card-body g-6">
                <div id="horizontalBarChart"></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Grafik Siswa Pertahun</h5>
            </div>
            <div class="card-body">
                <div id="chartSiswaTahun"></div>
            </div>
        </div>
    </div>
</div>