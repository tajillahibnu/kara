<div id="page-detail" style="display: none;">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 info-name">Add a new Product</h4>
            <p class="mb-0 info-tanggal">Orders placed across your store</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <button type="button" onclick="goToPage(this)" data-close="detail" data-open="main" class="btn btn-danger waves-effect waves-light">Back</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body pb-0 mb-4">
            <div class="border border-light-primary rounded-2 border-2 p-4 mt-2">
                <form action="javascript:javascript:onFilterInduka()" method="post">
                    <div class="row">
                        <div class="col-12 col-md">
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <div class="mt-4">
                                        <label class="form-label" for="filter_jurusan">Jurusan</label>
                                        <select id="filter_jurusan" name="filter_jurusan" class="select2 form-select form-control form-control-sm" data-placeholder="Select Jurusan">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 align-self-center">
                            <button class="btn btn-sm btn-outline-primary mb-3 w-100" type="submit"><i class="fa fa-search mx-2"></i> Cari</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="onFilterInduka(true)"><i class="fa fa-times mx-2"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-datatable table-responsive pt-0 mt-4">
            <table id="table-induka" class="datatables-basic table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama Induka</th>
                        <th>Jumlah Siswa</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<div class="modal fade show" id="modalInduka" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Induka</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPriodeInduka" action="javascript:onSaveInduka('formPriodeInduka')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="select_induka">Induka</label>
                            <select id="select_induka" name="select_induka[]" class="select2 form-select" multiple data-placeholder="Select Induka"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formPriodeInduka').submit()" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>
        </div>
    </div>
</div>