var targetID = '';
$(() => {
    APP.combov1({
        el: ['#tahun_ajaran'],
        url: `${BASE_API_MENU}/combo/tahun-pelajaran`,
        fild_id: 'name',
        fild_name: 'name',
        select2: true,
        dropdownParent: '#mainModal',
    })

    APP.combov1({
        el: ['#tingkatan'],
        url: `${BASE_API_MENU}/combo/tingkat`,
        fild_id: 'romawi',
        fild_name: 'romawi_name',
        select2: true,
        allowClear: false,
        dropdownParent: '#mainModal',
    })

    $('#batas_registrasi').flatpickr({
        monthSelectorType: 'static',
        dateFormat: 'd-m-Y'
    });
    $('#tanggal_mulai').flatpickr({
        monthSelectorType: 'static',
        dateFormat: 'd-m-Y'
    });
    $('#tanggal_selesai').flatpickr({
        monthSelectorType: 'static',
        dateFormat: 'd-m-Y'
    });

    mainTable();
})

mainTable = () => {
    APP.initTable({
        el: '#maintable', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/main-table', // URL endpoint API untuk mengambil data
        index: 1, // Kolom yang diurutkan
        dom: `
        <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
            <"d-flex justify-content-center justify-content-md-end align-items-baseline"
            <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
        <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
        buttons: [{
            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Priode PKL</span>',
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
                    return `
                    <div class="d-flex flex-column">
                        <span>${full['name']}</span>
                        <small>Registrasi : ${moment(full['batas_registrasi']).format("DD-MM-Y")}</small>
                    </div>
                    `
                },
            },
            {
                targets: 2,
                width: "150px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return `
                    <div class="d-flex flex-column">
                        <small>Mulai : ${moment(full['tanggal_mulai']).format("DD-MM-Y")}</small>
                        <small>Selesai : ${moment(full['tanggal_selesai']).format("DD-MM-Y")}</small>
                    </div>
                    `
                },
            },
            {
                targets: 3,
                width: "100px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return `
                    <div class="d-flex flex-column">
                        <span>${full['kuota_siswa']} Siswa</span>
                        <small>${full['syarat_tingkat']}</small>
                    </div>
                    `
                    return;
                },
            },
            {
                targets: 4,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['status'];
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

newData = () => {
    targetID = '';
    $('#formMain').trigger('reset');
    $('#mainModal').modal('show');
}

editData = (el) => {
    var data = $(el).data('params');
    data = JSON.parse(atob(data));
    targetID = data['id'];

    $.each(data, (i, v) => {
        // Penanganan khusus untuk tingkatan[]
        if (i === 'tingkatan') {
            let inputElement = $(`[name="tingkatan[]"]`);

            try {
                // Jika v adalah string, coba decode (parse) dua kali
                if (typeof v === 'string') {
                    v = JSON.parse(v);  // Pertama kali decode
                }

                // Jika masih berupa string setelah parse pertama, coba decode lagi
                if (typeof v === 'string') {
                    v = JSON.parse(v);  // Decode kedua kali jika diperlukan
                }

                // Pastikan v adalah array, jika tidak buat kosong
                if (!Array.isArray(v)) {
                    console.warn("Value bukan array:", v);
                    v = [];
                }
            } catch (e) {
                console.warn("JSON parse gagal:", v);
                v = [];
            }

            // Inject option secara manual jika select2 AJAX belum ada datanya
            v.forEach(val => {
                if (inputElement.find(`option[value="${val}"]`).length === 0) {
                    inputElement.append(new Option(val, val, true, true));
                }
            });

            // Set nilai select2 dan trigger change setelah delay
            setTimeout(() => {
                inputElement.val(v).trigger('change');
            }, 300);

            return;  // Skip untuk field 'tingkatan' ini

        }


        // Penanganan umum input
        let inputElement = $(`[name="${i}"]`);
        inputElement.val(v).trigger('change');

        if (inputElement.hasClass('flatpickr-input')) {
            let formattedDate = v.split('-').reverse().join('-');
            inputElement[0]._flatpickr.setDate(formattedDate, true);
        }
    });

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
        console.error("Fetch error:", error);
        APP.unblock();
    });
}

setActive = (el) => {
    var data = $(el).data('params')
    data = JSON.parse(atob(data));
    targetID = data['id'];
    APP.confirm({
        title: 'Are you sure?',
        text: 'Are you sure you want to change the status of this item?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Changes Status!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            APP.axiosRequest({
                url: `${BASE_API_MENU}/status`,
                data: {
                    id: targetID,
                    data: data
                },
            }).then(data => {
                APP.reloadTable();
                APP.showToast({
                    type: data.status,
                    message: data.message,
                });
            }).catch(error => {
                console.error("Fetch error:", error);
            });
        }
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
                APP.showToast({
                    type: data.status,
                    message: data.message,
                });
            }).catch(error => {
                console.error("Fetch error:", error);
            });
        }
    });
}