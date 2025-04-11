<div id="page-detail">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-tile mb-0">Daftar Registrasi</h5>
                </div>
                <div class="card-body pb-0 mb-0">
                    <div class="border border-light-primary rounded-2 border-2 p-4 mt-2">
                        <form action="javascript:javascript:onFilter()" method="post">
                            <div class="row">
                                <div class="col-12 col-md">
                                    <div class="row">
                                        <div class="col-6 col-md-6">
                                            <div class="mt-4">
                                                <label class="form-label" for="filter_priode">Priode PKL</label>
                                                <select id="filter_priode" name="filter_priode" class="select2 form-select form-control form-control-sm" data-placeholder="Select Priode">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <div class="mt-4">
                                                <label class="form-label" for="filter_tipe">Tipe</label>
                                                <select id="filter_tipe" name="filter_tipe" class="select2 form-select form-control form-control-sm" data-placeholder="Select Tahun">
                                                    <option selected value="all">Tampilkan Semua</option>
                                                    <option value="seleksi">Seleksi</option>
                                                    <option value="mandiri">Mandiri</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 align-self-center">
                                    <button class="btn btn-sm btn-outline-primary mb-3 w-100" type="submit"><i class="fa fa-search"></i> Cari</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="onFilter(true)"><i class="fa fa-times"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
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

@include('pkl::pkl.pendaftaran.kepala_jurusan.form')