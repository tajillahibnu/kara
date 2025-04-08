var targetID = '';
var map = null;
var marker = null;
$(() => {
    APP.combov1({
        el: ['#jurusan_id'],
        url: `${BASE_API_MENU}/combo/jurusan`,
        fild_id: 'id',
        fild_name: 'name',
        select2: true,
        allowClear: false,
        dropdownParent: '#mainModal',
    })
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
            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Tambah Data</span>',
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
                        <div class="d-flex justify-content-left align-items-center">
                            <div class="d-flex flex-column">
                                <h6 class="text-truncate mb-0">${full['name']}</h6>
                                <small class="text-truncate">${full['jurusan_name']}</small>
                            </div>
                        </div>
                        `
                },
            },
            {
                targets: 2,
                data: 'kota',
                render: function (data, type, full, meta) {
                    return full['kota'];
                },
            },
            {
                targets: 3,
                data: 'phone',
                render: function (data, type, full, meta) {
                    return full['phone'];
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
    $('#mainModal').off('shown.bs.modal').on('shown.bs.modal', function () {
        let lat = parseFloat(latitude) || -7.9797;
        let lng = parseFloat(longitude) || 112.6304;

        if (!map) {
            map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Event klik pada map untuk update marker
            map.on('click', function (e) {
                const clickedLat = e.latlng.lat;
                const clickedLng = e.latlng.lng;

                // Update atau buat marker baru
                if (marker) {
                    marker.setLatLng([clickedLat, clickedLng]);
                } else {
                    marker = L.marker([clickedLat, clickedLng]).addTo(map);
                }

                // Simpan ke input form (supaya bisa disimpan ke DB)
                $(`[name="latitude"]`).val(clickedLat);
                $(`[name="longitude"]`).val(clickedLng);
            });

        } else {
            map.setView([lat, lng], 13);
            setTimeout(() => map.invalidateSize(), 100);
        }

        // Update marker awal
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
    });

}

editData = (el) => {
    var data = $(el).data('params');
    var latitude = '';
    var longitude = '';
    data = JSON.parse(atob(data));
    targetID = data['id'];

    $.each(data, (i, v) => {
        if (i === 'latitude') {
            latitude = v;
        } else if (i === 'longitude') {
            longitude = v;
        }
        let inputElement = $(`[name="${i}"]`);
        inputElement.val(v).trigger('change');
    });

    // Tampilkan modal terlebih dahulu
    $('#mainModal').modal('show');

    // Setelah modal ditampilkan, baru inisialisasi / refresh map
    $('#mainModal').on('shown.bs.modal', function () {
        let lat = parseFloat(latitude) || -7.9797;
        let lng = parseFloat(longitude) || 112.6304;

        if (!map) {
            map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Event klik pada map untuk update marker
            map.on('click', function (e) {
                const clickedLat = e.latlng.lat;
                const clickedLng = e.latlng.lng;

                // Update atau buat marker baru
                if (marker) {
                    marker.setLatLng([clickedLat, clickedLng]);
                } else {
                    marker = L.marker([clickedLat, clickedLng]).addTo(map);
                }

                // Simpan ke input form (supaya bisa disimpan ke DB)
                $(`[name="latitude"]`).val(clickedLat);
                $(`[name="longitude"]`).val(clickedLng);
            });

        } else {
            map.setView([lat, lng], 13);
            setTimeout(() => map.invalidateSize(), 100);
        }

        // Update marker awal
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
    });

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