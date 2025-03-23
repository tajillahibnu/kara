<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var targetID = '';
    $(() => {
        APP.combov1({
            el: ['#jurusan_id'],
            url: `${BASE_API_MENU}/combo/jurusan`,
            fild_id: 'id',
            fild_name: 'name',
            select2: true,
            dropdownParent: '#mainModal',
        })
        mainTable();
    })

    tableSiswa = () => {
        APP.initTable({
            el: '#table-siswa',
            url: BASE_API_MENU + '/table-siswa',
            index: 1,
            data: {
                id: targetID
            },
            columnDefs: [{
                    targets: 1,
                    data: 'nama',
                    render: function(data, type, full, meta) {
                        return `
                    <div class="d-flex justify-content-left align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-info">${getInitials(full['nama'])}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="text-truncate mb-0">${full['nama']}</h6>
                            <small class="text-truncate">${full['nis'] == null ? '[-]' : '['+full['nis']+']'}</small>
                        </div>
                    </div>
                    `
                    },
                },
                {
                    targets: 2,
                    data: 'romawi',
                    render: function(data, type, full, meta) {
                        return full['romawi'];
                    },
                },
                {
                    targets: 3,
                    width: "50px",
                    render: function(data, type, full, meta) {
                        return full['status'];
                    },
                },
                {
                    targets: 4,
                    width: "50px",
                    // data: 'name',
                    render: function(data, type, full, meta) {
                        return full['action'];
                    },
                }
            ]
        });
    }
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
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Upload Siswa</span>',
                className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                action: function(e, dt, node, config) {
                    newData()
                },
            }],
            columnDefs: [{
                    targets: 1,
                    data: 'original_name',
                    render: function(data, type, full, meta) {
                        return full['original_name'];
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full['jurusan_name'];
                    },
                },
                {
                    targets: 3,
                    width: "50px",
                    render: function(data, type, full, meta) {
                        return full['status'];
                    },
                },
                {
                    targets: 4,
                    width: "50px",
                    // data: 'name',
                    render: function(data, type, full, meta) {
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

    onDetails = (el) => {
        var data = $(el).data('params')
        data = JSON.parse(atob(data));
        var errorsArray = JSON.parse(data.errors);

        targetID = data['id'];
        $.each(data, (i, v) => {
            $(`[name="${i}"]`).val(v);
        })
        // var htmlTable = '';
        // errorsArray.forEach(error => {
        //     htmlTable += `
        //         <tr>
        //             <td>${error.baris}</td>
        //             <td>${error.diskripsi}</td>
        //         </tr>
        //     `;
        // });

        // $('#box-table-log').html(`
        //     <table id="log-error" class="datatables-basic table">
        //         <thead>
        //             <tr>
        //                 <th>Baris</th>
        //                 <th>Deskripsi</th>
        //             </tr>
        //         </thead>
        //         <tbody>
        //             <tr>
        //                 <td>1</td>
        //                 <td>asdasdasd</td>
        //             </tr>
        //             ${htmlTable}
        //         </tbody>
        //     </table>
        // `);
        // console.log(htmlTable)
        // Jika menggunakan DataTable, inisialisasi di sini
        // if ($.fn.DataTable) {
        //     $('#log-error').DataTable();
        // }

        $('#page-main').fadeOut('slow', () => {
            $(`#page-detail`).fadeIn();
            setTimeout(() => {
                tableSiswa();
            }, 400);
        });
    }

    onBack = () => {
        $('#page-detail').fadeOut('slow', () => {
            targetID = '';
            $(`#page-main`).fadeIn();
        });
    }

    doSave = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'siswa';

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
</script>