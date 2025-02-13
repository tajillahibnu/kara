var targetID = '';
$(() => {
    // mainTable();
    APP.combov1({
        el: ['#select_roles'],
        url: `${BASE_API_MENU}/combo/roles`,
        fild_id: 'name',
        fild_name: 'name',
        select2:true,
        dropdownParent: '#mainModal',
        callback: (response) => {
            if (response.error) {
                console.error("Error:", response.error);
            } else {
                mainTable();
                // $('.form-select').select2();
                // $('#select_roles').select2({
                //     placeholder: "Select options", // Placeholder
                //     allowClear: true, // Menambahkan opsi hapus semua
                //     tags: true, // Mengizinkan pengguna menambahkan opsi baru jika diperlukan
                //     closeOnSelect: false, // Dropdown tetap terbuka setelah pemilihan
                //     width: '100%' // Mengatur lebar dropdown sesuai kebutuhan
                // });
                // Custom Styling (Optional)
                // $('#select_roles').on('select2:select', function (e) {
                //     let data = e.params.data;
                //     console.log(`Selected: ${data.id}`);
                // });
            }
        }
    })
})

mainTable = () => {
    APP.initTable({
        el: '#maintable', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/main-table', // URL endpoint API untuk mengambil data
        pageLength: 10, // Jumlah baris per halaman
        sorting: 'asc', // Urutan sorting default
        index: 1, // Kolom yang diurutkan
        dom: `
        <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
            <"d-flex justify-content-center justify-content-md-end align-items-baseline"
            <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
        <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
        buttons: [{
            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Tambah Pegawai</span>',
            className: "add-new btn btn-primary ms-2 waves-effect waves-light",
            action: function (e, dt, node, config) {
                newData()
            },
        }],
        columnDefs: [
            {
                targets: 1,
                data: 'name',
                render: function (data, type, full, meta) {
                    is_email_verified = full['email_verified_at'] == null ? '' : '<img class="mark-img" src="../assets/img/front-pages/icons/mark.png" alt="mark icon">';
                    return `
                    <div class="d-flex justify-content-left align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-info">WS</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="text-truncate mb-0">${full['name']}</h6>
                            <small class="text-truncate">${full['email']} ${is_email_verified}</small>
                        </div>
                    </div>
                    `
                },
            },
            {
                targets: 2,
                width: "100px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['role_name'];
                },
            },
            {
                targets: 3,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['status'];
                },
            },
            {
                targets: -1,
                width: "50px", // Mengatur lebar kolom nomor urut
                orderable: false,
                render: function (data, type, full, meta) {
                    return full['action'];
                },
            }
        ]
    });
}

newData = () => {
    APP.block();
    targetID = '';
    $('#formMain').trigger('reset');
    $('#mainModal').modal('show');
    APP.unblock();
}

editData = (el) => {
    APP.block();
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    targetID = data['id'];
    $.each(data, (i, v) => {
        $(`[name="${i}"]`).val(v);
    })
    $('#mainModal').modal('show');
    APP.unblock();
}

editRoles = (el) => {
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    targetID = data['id'];
    $.each(data, (i, v) => {
        $(`[name="${i}"]`).val(v);
    })
    $('#mainModal').modal('show');
}

onSaveIt = (name) => {
    APP.block();
    var form = $(`#${name}`)[0];
    var formData = new FormData(form);
    var action = targetID == '' ? 'store' : 'update/' + targetID;

    APP.axiosRequest({
        url: `${BASE_API_MENU}/${action}`,
        data: formData,
    }).then(data => {
        APP.reloadTable();
        $('#mainModal').modal('hide');
        APP.showToast({
            type: data.status,
            message: data.message,
        });
        APP.unblock();
    }).catch(error => {
        APP.unblock();
        console.error("Fetch error:", error);
    });
}

deleteData = (el) => {
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    targetID = data['id'];
    APP.confirm({
        title: 'Are you sure?',
        text: 'Do you want to delete this item?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            APP.axiosRequest({
                url: `${BASE_API_MENU}/delete`,
                data: {
                    id: targetID
                },
            }).then(data => {
                APP.reloadTable();
                APP.notif({
                    type: data.status,
                    message: data.message,
                });
            }).catch(error => {
                console.error("Fetch error:", error);
            });
        }
    });

}

