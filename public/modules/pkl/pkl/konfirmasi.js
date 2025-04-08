$(() => {
    mainTable()
})

mainTable = () => {
    APP.initTable({
        el: '#maintable', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/main-table', // URL endpoint API untuk mengambil data
        order: [
            [2, 'asc'],
            [1, 'asc'],
        ],
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
                data: 'siswas.rombel_name',
                render: function (data, type, full, meta) {
                    return `
                        <div class="d-flex justify-content-left align-items-center">
                            <div class="d-flex flex-column">
                                <h6 class="text-truncate mb-0">${full['rombel_name']}</h6>
                                <small class="text-truncate">${full['jurusan'] == null ? '[-]' : '[' + full['jurusan'] + ']'}</small>
                            </div>
                        </div>
                    `
                },
            },
            {
                targets: 3,
                width: "50px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return full['status_badge'];
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

confirmAll = (el) => {
    var data = $(el).data('params')
    var tipe = $(el).data('tipe')
    data = JSON.parse(atob(data));
    console.log(tipe)
    targetID = data['id'];
    APP.confirm({
        title: 'Are you sure?',
        text: tipe == 'completed' ? 'Apakah anda ingin menyetujui registrasi PKL? menyetujui akan by pass tidak sesuai prosedur' : 'Apakah anda ingin membatalkan registrasi PKL? membatalkan akan by pass tidak sesuai prosedur',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: tipe == 'completed' ? 'Completed!' : 'Rejected!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: tipe == 'completed' ? 'btn btn-primary waves-effect waves-light text-white' : 'btn btn-danger waves-effect waves-light text-white',
        },
    }).then((result) => {
        if (result.isConfirmed) {
            APP.axiosRequest({
                url: `${BASE_API_MENU}/confirmall`,
                data: {
                    id: targetID,
                    tipe: tipe,
                    task: 'bypass'
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