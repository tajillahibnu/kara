<div class="modal fade show" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMain" action="javascript:onSaveIt('formMain')" method="post">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Nama Perusahaan</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Nama Lengkap Siswa" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Email</label>
                            <input class="form-control" id="email" name="email" type="email" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Phone</label>
                            <input class="form-control" id="phone" name="phone" type="text" required="">
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="name">Alamat</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="$('#formMain').submit()" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div>