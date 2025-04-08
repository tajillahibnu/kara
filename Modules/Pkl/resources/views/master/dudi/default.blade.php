<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-tile mb-0">Daftar Lokasi Industri</h5>
    </div>
    <div class="card-datatable table-responsive pt-0">
        <table id="maintable" class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Kota</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('pkl::master.dudi.form')