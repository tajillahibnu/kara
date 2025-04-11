<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Informasi Permohonan PKL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <small class="card-text text-uppercase text-muted small">Informasi</small> -->
                <table class="mt-2">
                    <tr>
                        <td style="width: 30%;vertical-align: top;"><span class="fw-medium">NIS</span></td>
                        <td style="width: 5%;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="width: 60;vertical-align: top;"><span class="info-nis"></span></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Nama</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-name"></span></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Kelas</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-rombel_name"></span></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Jurusan</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-jurusan_name"></span></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Lokasi PKL</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-dudi_name"></span></td>
                    </tr>
                </table>
            </div>
            <div id="box-konfirmasi" class="modal-footer justify-content-between">
                <button type="button" id="btnRjct" data-params="" data-tipe="rejected" onclick="confirmAll(this)" class="btn btn-danger waves-effect">
                    <i class="fas fa-times"></i> Reject
                </button>
                <button type="button" id="btnOk" data-params="" data-tipe="completed" onclick="confirmAll(this)" class="btn btn-success waves-effect waves-light">
                    <i class="fas fa-check"></i> Accept
                </button>
            </div>
        </div>
    </div>
</div>