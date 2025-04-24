<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-7">
                    <div class="card-body text-nowrap">
                        <h5 class="mb-0">Welcome back,</h5>
                        <span class="h4 mt-0"> {{Auth::user()->name}} </span>
                    </div>
                </div>
                <div class="col-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="../../assets/img/illustrations/card-advance-sale.png" height="140" alt="view sales">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <small class="card-text text-uppercase text-muted small">Informasi</small>
                                <table class="mt-2">
                                    <tr class="mb-2">
                                        <td style="width: 5%;vertical-align: top;"><i class="ti ti-category-minus ti-lg"></i></td>
                                        <td style="width: 30%;vertical-align: top;"><span class="fw-medium mx-2">NIK</span></td>
                                        <td style="width: 5%;vertical-align: top;"><span class="fw-medium mx-2">:</span></td>
                                        <td style="width: 60;vertical-align: top;"><span class="info-nik"></span></td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td style="vertical-align: top;"><i class="ti ti-box ti-lg"></i></td>
                                        <td style="vertical-align: top;"><span class="fw-medium mx-2">Email</span></td>
                                        <td style="vertical-align: top;"><span class="fw-medium mx-2">:</span></td>
                                        <td style="vertical-align: top;"><span class="info-email"></span></td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td style="vertical-align: top;"><i class="ti ti-tags ti-lg"></i></td>
                                        <td style="vertical-align: top;"><span class="fw-medium mx-2">Jabatan</span></td>
                                        <td style="vertical-align: top;"><span class="fw-medium mx-2">:</span></td>
                                        <td style="vertical-align: top;"><span class="info-jabatan"></span></td>
                                    </tr>
                                </table>
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
</div>