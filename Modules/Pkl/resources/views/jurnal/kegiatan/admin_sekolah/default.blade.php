<style>
    .column-top {
        vertical-align: top !important;
    }
    .column-deskripsi {
        max-width: 250px;
        white-space: normal !important;
        word-wrap: break-word;
    }

    .read-more {
        color: #007bff;
        cursor: pointer;
        font-size: 0.9em;
    }

    .read-more:hover {
        text-decoration: underline;
    }
</style>

<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-tile mb-0">Daftar Jurnal Kegiatan</h5>
    </div>
    <div class="card-datatable table-responsive pt-0">
        <table id="maintable" class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Nama Kegiatan</th>
                    <th>Jam</th>
                    <th>Deskripsi</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>