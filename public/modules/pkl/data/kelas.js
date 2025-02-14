var targetID = '';
var dataRombel = '';
$(() => {
    combo();
    mainTable();
})

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
                    // is_email_verified = full['email_verified_at'] == null ? '' : '<img class="mark-img" src="../assets/img/front-pages/icons/mark.png" alt="mark icon">';
                    return `
                    <div class="d-flex justify-content-left align-items-center">
                        <div class="d-flex flex-column">
                            <h6 class="text-truncate mb-0">${full['name']}</h6>
                            <small class="text-truncate"></small>
                        </div>
                    </div>
                    `
                },
            },
            {
                targets: 2,
                render: function (data, type, full, meta) {
                    return full['jurusan_name'];
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

editData = (el) => {
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    dataRombel = data;
    targetID = data['id'];
    $.each(data, (i, v) => {
        // $(`[name="${i}"]`).val(v);
        $(`.info-${i}`).html(v);
    })

    tableSiswa();
    setTimeout(() => {
        onBack(`<span data-close="main" data-open="detail" >`)
    }, 300);
    // $('#page-main').fadeOut('slow', () => {
    //     $(`#page-detail`).fadeIn();
    // });
    // $(`#page-detail`).fadeIn('slow', () => {
    // });
}

combo = () => {
    APP.combov1({
        el: ['#tingkat_id'],
        url: `${BASE_API_MENU}/combo/tingkat`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        dropdownParent: '#mainModal',
    })
    APP.combov1({
        el: ['#jurusan_id'],
        url: `${BASE_API_MENU}/combo/jurusan`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        dropdownParent: '#mainModal',
    })
}

onBack = (el) => {
    var data = $(el).data();
    $(`#page-${data['close']}`).fadeOut('slow', () => {
        $(`#page-${data['open']}`).fadeIn();
    });
}

tableSiswa = (el = 'tableSiswa', tipe = 'siswa') => {
    APP.initTable({
        el: '#' + el, // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/table-siswa', // URL endpoint API untuk mengambil data
        index: 1, // Kolom yang diurutkan
        data: {
            kelas: targetID,
            tipe: tipe,
            jurusan: dataRombel['jurusan_id'],
            tingkat: dataRombel['tingkat_id']
        },
        columnDefs: [
            {
                targets: 1,
                data: 'name',
                render: function (data, type, full, meta) {
                    // is_email_verified = full['email_verified_at'] == null ? '' : '<img class="mark-img" src="../assets/img/front-pages/icons/mark.png" alt="mark icon">';
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
                width: "50px",
                render: function (data, type, full, meta) {
                    return full['jk'];
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

modalEnrolSiswa = () => {
    tableSiswa('tableSiswaEnrol', 'enrol')
    $('#enrolSiswa').modal('show')
}

enrolSiswa = (el) => {
    APP.block();
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    console.log(data);
    APP.axiosRequest({
        url: `${BASE_API_MENU}/enrol-siswa`,
        data: {
            dataRombel: dataRombel,
            dataSiswa: data
        },
    }).then(data => {
        APP.reloadTable({ el: '#tableSiswaEnrol' });
        APP.reloadTable({ el: '#tableSiswa' });
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