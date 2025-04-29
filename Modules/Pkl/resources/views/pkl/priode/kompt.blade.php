<div id="page-kompt" style="display: none;">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 info-name">Add a new Product</h4>
            <p class="mb-0 info-tanggal">Orders placed across your store</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <button type="button" onclick="goToPage(this)" data-close="kompt" data-open="main" class="btn btn-danger waves-effect waves-light">Back</button>
        </div>
    </div>
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table id="table-kompt" class="datatables-basic table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Jurusan</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade show" id="modalKompt" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNewKompt" action="javascript:onSaveKompt('formNewKompt')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="select_kompt">Jurusan</label>
                            <select id="select_kompt" name="select_kompt[]" class="select2 form-select" multiple data-placeholder="Select Jurusan"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formNewKompt').submit()" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>
        </div>
    </div>
</div>