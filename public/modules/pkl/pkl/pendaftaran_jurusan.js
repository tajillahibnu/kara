var targetID = "";
var temp_priode = null;
$(() => {
    APP.combov1({
        el: ['#filter_tingkat'],
        url: `${BASE_API_MENU}/combo/tingkat`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        allowClear: false,
        choose: false,
        dropdownParent: '#mainModal',
    })
    APP.combov1({
        el: ['#periode_id'],
        url: `${BASE_API_MENU}/combo/priode_pkl`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        allowClear: false,
        choose: false,
        dropdownParent: '#mainModal',
    })

    APP.combov1({
        el: ['#filter_priode'],
        url: `${BASE_API_MENU}/combopriode`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        allowClear: false,
        callback: (item) => {
            item['data'].forEach(element => {
                if (element['is_active']) {
                    temp_priode = element['id'];
                    $('#filter_priode').val(element['id']).trigger('change');
                }
            });
            
            setTimeout(() => {
                onFilter();
            }, 800);
        }
    })
    $('#filter_tipe').select2({
        minimumResultsForSearch: -1
    });
})

onFilter = (isReset = false) => {
    if (isReset) {
        $('#filter_priode').val(temp_priode).trigger('change');
        $('#filter_tipe').val('all').trigger('change');
    }
    mainTable()
}

mainTable = () => {
    APP.initTable({
        el: '#table-registrasi', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/table-registrasi', // URL endpoint API untuk mengambil data
        index: 1, // Kolom yang diurutkan
        dom: `
        <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
            <"d-flex justify-content-center justify-content-md-end align-items-baseline"
            <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
        <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
        buttons: [{
            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Registrasi</span>',
            className: "add-new btn btn-primary ms-2 waves-effect waves-light",
            action: function (e, dt, node, config) {
                registrasi_siswa()
            },
        }],
        data: {
            priode: $('#filter_priode').val(),
            tipe: $('#filter_tipe').val(),
            jurusan: targetID,
        },
        columnDefs: [
            {
                targets: 1,
                data: 'siswas.name',
                render: function (data, type, full, meta) {
                    return `
                    <div class="d-flex justify-content-left align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-info">${getInitials(full['name'])}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="text-truncate mb-0">${full['name']}</h6>
                            <small class="text-truncate">${full['nis'] == null ? '[-]' : '[' + full['nis'] + ']'}</small>
                        </div>
                    </div>
                    `
                },
            },
            {
                targets: 2,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['rombel_name'];
                },
            },
            {
                targets: 3,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return String(full['registration_type']).toUpperCase();
                },
            },
            {
                targets: 4,
                width: "50px", // Mengatur lebar kolom nomor urut
                data: 'siswas.nis',
                render: function (data, type, full, meta) {
                    return full['status_badge'];
                },
            },
            {
                targets: -1,
                width: "50px", // Mengatur lebar kolom nomor urut
                // data: 'name',
                visible: false,
                render: function (data, type, full, meta) {
                    return full['action'];
                },
            }
        ]
    });
}

onDetails = (el) => {
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    targetID = data['id'];
    $.each(data, (i, v) => {
        // $(`[name="${i}"]`).val(v);
        $(`.info-${i}`).html(v);
    })
    onBack(`<span data-close="main" data-open="detail">`)
    setTimeout(() => {
        tableRegistrasi()
    }, 400);

}

registrasi_siswa = () => {
    comboSiswa()
    $('#formMain').trigger('reset');
    $('#mainModal').modal('show');
}

comboSiswa = () => {
    APP.combov1({
        el: ['#siswa_id'],
        url: `${BASE_API_MENU}/combosiswa`,
        fild_id: 'id',
        fild_name: 'name',
        data: {
            tingkat_id: $('#filter_tingkat').val()
        },
        select2: true,
        choose: false,
        autoselect: false,
        dropdownParent: '#mainModal',
    })
}

saveItRegister = (name) => {
    APP.block();
    var form = $(`#${name}`)[0];
    var formData = new FormData(form);
    formData.append('jurusan_id', targetID)

    APP.axiosRequest({
        url: `${BASE_API_MENU}/register`,
        data: formData,
    }).then(data => {
        APP.reloadTable({
            el: '#table-registrasi'
        });
        $('#mainModal').modal('hide');
        APP.showToast({
            type: data.status,
            message: data.message,
        });
        APP.unblock();
    }).catch(error => {
        console.error("Fetch error:", error);
        APP.unblock();
    });
}