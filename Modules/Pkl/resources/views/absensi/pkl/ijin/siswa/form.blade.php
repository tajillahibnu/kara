<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Ijin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <label for="tanggal_mulai" class="form-label">Mulai</label>
                            <input type="text" id="tanggal_mulai" name="tanggal_mulai" class="form-control" readonly>
                        </div>
                        <div class="col-6 mb-4">
                            <label for="tanggal_selesai" class="form-label">Berakhir</label>
                            <input type="text" id="tanggal_selesai" name="tanggal_selesai" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="selisih_hari" class="form-label">Total Ijin</label>
                        <input type="text" id="selisih_hari" name="selisih_hari" class="form-control" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="alasan" class="form-label">Note</label>
                        <textarea rows="8" class="form-control" maxlength="1000" name="alasan" id="alasan"></textarea>
                        <small id="alasan-counter" class="text-muted">0 / 1000 karakter</small>
                    </div>
                    <div class="mb-4">
                        <label for="waktu" class="form-label">Lampiran</label>
                        <input type="text" id="waktu" name="waktu" class="form-control" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formMain').submit()" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="mainView" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Details Ijin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Tanggal</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-tanggal_range"></span></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Bukti</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-dudi_name"></span></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">Alasan</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="fw-medium">:</span></td>
                        <td style="padding-top: 14px;vertical-align: top;"><span class="info-alasan"></span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>