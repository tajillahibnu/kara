var targetID = "";
$(() => {
    APP.combov1({
        el: ['#filter_tingkat'],
        url: `${BASE_API_MENU}/combo/tingkat`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        dropdownParent: '#mainModal',
    })
    APP.combov1({
        el: ['#periode_id'],
        url: `${BASE_API_MENU}/combo/priode_pkl`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        dropdownParent: '#mainModal',
    })

    APP.combov1({
        el: ['#filter_priode'],
        url: `${BASE_API_MENU}/combopriode`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        callback:(item)=>{
            item['data'].forEach(element => {
                if(element['is_active']){
                    $('#filter_priode').val(element['id']).trigger('change');
                }
            });
        }
    })
    $('#filter_tipe').select2({
        minimumResultsForSearch: -1
    });
    mainTable();
})

onBack = (el) => {
    var data = $(el).data();
    $(`#page-${data['close']}`).fadeOut('slow', () => {
        $(`#page-${data['open']}`).fadeIn();
    });
}

mainTable = () => {
    APP.initTable({
        el: '#maintable', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/main-table', // URL endpoint API untuk mengambil data
        index: 1, // Kolom yang diurutkan
        columnDefs: [
            {
                targets: 1,
                data: 'name',
                render: function (data, type, full, meta) {
                    return `
                    <div class="d-flex flex-column">
                        <span>${full['name']}</span>
                    </div>
                    `
                },
            },
            {
                targets: 2,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['total'];
                },
            },
            {
                targets: 3,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['diterima'];
                },
            },
            {
                targets: 4,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['ditolak'];
                },
            },
            {
                targets: -1,
                width: "50px", // Mengatur lebar kolom nomor urut
                // data: 'name',
                render: function (data, type, full, meta) {
                    return full['action'];
                },
            }
        ]
    });
}

tableRegistrasi = () => {
    APP.initTable({
        el: '#table-registrasi', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/table-registrasi', // URL endpoint API untuk mengambil data
        index: 1, // Kolom yang diurutkan
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
            jurusan_id: targetID,
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