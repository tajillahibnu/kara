<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-tile mb-0">Daftar Kelas</h5>
    </div>
    <div class="card-body pb-0 mb-0">
        <div class="border border-light-primary rounded-2 border-2 p-4 mt-2">
            <form action="javascript:javascript:onFilter()" method="post">
                <div class="row">
                    <div class="col-12 col-md">
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="mt-4">
                                    <label class="form-label" for="filter_jurusan">Jurusan</label>
                                    <select id="filter_jurusan" name="filter_jurusan" class="select2 form-select form-control form-control-sm" data-placeholder="Select Jurusan">
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-md-3">
                                <div class="mt-4">
                                    <label class="form-label" for="filter_priode">Tingkat</label>
                                    <select id="filter_tingkat" name="filter_tingkat" class="select2 form-select form-control form-control-sm" data-placeholder="Select Tingkat">
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-md-3">
                                <div class="mt-4">
                                    <label class="form-label" for="filter_status">Status</label>
                                    <select id="filter_status" name="filter_status" class="select2 form-select form-control form-control-sm">
                                        <option value="enable">Enable</option>
                                        <option value="disbale">Disbale</option>
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
        <table id="maintable" class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Walikelas</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('pkl::master.rombel.form')