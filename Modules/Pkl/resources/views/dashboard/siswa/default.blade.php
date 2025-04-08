<div class="row">
    <div class="col-lg-8">
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
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="card-text text-uppercase text-muted small">Informasi</small>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Kelas:</span>
                                        <span class="info-rombel_name"></span>
                                    </li>
                                    <!-- <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-check ti-lg"></i><span class="fw-medium mx-2">Walikleas:</span>
                                        <span class="info-tanggal_lahir"></span>
                                    </li> -->
                                    <li class="d-flex mb-4">
                                        <i class="ti ti-crown ti-lg"></i><span class="fw-medium mx-2">Jurusan:</span>
                                        <span class="info-jurusan_name"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <small class="card-text text-uppercase text-muted small">Informasi Kontak</small>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-phone-call ti-lg"></i><span class="fw-medium mx-2"></span>
                                        <span class="info-no_wa"></span>
                                    </li>
                                    <li class="d-flex align-items-center mb-4">
                                        <i class="ti ti-mail ti-lg"></i><span class="fw-medium mx-2"></span>
                                        <span class="info-email"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-none">
                <div class="row">
                    <!-- Card Border Shadow -->
                    <div class="col-lg-12">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar me-4">
                                        <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-truck ti-28px"></i></span>
                                    </div>
                                    <h4 class="mb-0">42</h4>
                                </div>
                                <p class="mb-1">On route vehicles</p>
                                <p class="mb-0">
                                    <span class="text-heading fw-medium me-2">+18.2%</span>
                                    <small class="text-muted">than last week</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <div class="card card-border-shadow-warning h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar me-4">
                                        <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-alert-triangle ti-28px"></i></span>
                                    </div>
                                    <h4 class="mb-0">8</h4>
                                </div>
                                <p class="mb-1">Vehicles with errors</p>
                                <p class="mb-0">
                                    <span class="text-heading fw-medium me-2">-8.7%</span>
                                    <small class="text-muted">than last week</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--/ Card Border Shadow -->
                </div>
            </div>
        </div>
    </div>
    <!-- Orders by Countries -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Informasi Siswa</h5>
                    <!-- <p class="card-subtitle">Di sini Anda dapat menemukan informasi penting terkait siswa, termasuk absensi, pengumuman terbaru, dan surat masuk serta keluar.</p> -->
                </div>
                <div class="dropdown">
                    <button
                        class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1"
                        type="button"
                        id="salesByCountryTabs"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-md text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountryTabs">
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="nav-align-top">
                    <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#link-info"
                                aria-controls="link-info"
                                aria-selected="true">
                                Info
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-link-surat"
                                aria-controls="navs-link-surat"
                                aria-selected="false">
                                Surat
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content border-0 mx-1">
                        <div class="tab-pane fade show active" id="link-info" role="tabpanel">
                            <ul class="timeline mb-0">
                                <li class="timeline-item ps-6 border-left-dashed">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                        <i class="ti ti-circle-check"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-success text-uppercase">sender</small>
                                        </div>
                                        <h6 class="my-50">Myrtle Ullrich</h6>
                                        <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                    </div>
                                </li>
                                <li class="timeline-item ps-6 border-transparent">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-primary text-uppercase">Receiver</small>
                                        </div>
                                        <h6 class="my-50">Barry Schowalter</h6>
                                        <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="border-1 border-light border-top border-dashed my-4"></div>
                            <ul class="timeline mb-0">
                                <li class="timeline-item ps-6 border-left-dashed">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                        <i class="ti ti-circle-check"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-success text-uppercase">sender</small>
                                        </div>
                                        <h6 class="my-50">Veronica Herman</h6>
                                        <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                    </div>
                                </li>
                                <li class="timeline-item ps-6 border-transparent">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-primary text-uppercase">Receiver</small>
                                        </div>
                                        <h6 class="my-50">Helen Jacobs</h6>
                                        <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="navs-link-surat" role="tabpanel">
                            <ul class="timeline mb-0">
                                <li class="timeline-item ps-6 border-left-dashed">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                        <i class="ti ti-circle-check"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-success text-uppercase">sender</small>
                                        </div>
                                        <h6 class="my-50">Barry Schowalter</h6>
                                        <p class="text-body mb-0">939 Orange, California(CA), 92118</p>
                                    </div>
                                </li>
                                <li class="timeline-item ps-6 border-transparent border-left-dashed">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-primary text-uppercase">Receiver</small>
                                        </div>
                                        <h6 class="my-50">Myrtle Ullrich</h6>
                                        <p class="text-body mb-0">101 Boulder, California(CA), 95959</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="border-1 border-light border-top border-dashed my-4"></div>
                            <ul class="timeline mb-0">
                                <li class="timeline-item ps-6 border-left-dashed">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                        <i class="ti ti-circle-check"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-success text-uppercase">sender</small>
                                        </div>
                                        <h6 class="my-50">Veronica Herman</h6>
                                        <p class="text-body mb-0">162 Windsor, California(CA), 95492</p>
                                    </div>
                                </li>
                                <li class="timeline-item ps-6 border-transparent">
                                    <span
                                        class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <div class="timeline-event ps-1">
                                        <div class="timeline-header">
                                            <small class="text-primary text-uppercase">Receiver</small>
                                        </div>
                                        <h6 class="my-50">Helen Jacobs</h6>
                                        <p class="text-body mb-0">487 Sunset, California(CA), 94043</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Orders by Countries -->
</div>