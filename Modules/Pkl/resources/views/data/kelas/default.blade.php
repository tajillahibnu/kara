<div id="page-main" class="card">
    <div class="card-header border-bottom">
        <h5 class="card-tile mb-0">Daftar Kelas</h5>
    </div>
    <div class="card-datatable table-responsive pt-0">
        <table id="maintable" class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Jurusan</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('pkl::data.kelas.form')
@include('pkl::data.kelas.modal')