<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    $(() => {
        mainTable();
    })

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            index: 1,
            columnDefs: [{
                    targets: 1,
                    data: 'name',
                    render: function(data, type, full, meta) {
                        return `
                        <div class="d-flex justify-content-left align-items-center">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-info">${getInitials(full['name'])}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="text-truncate mb-0">${full['name']}</h6>
                                <small class="text-truncate">${full['nis']} ${full['rombel_name']}</small>
                            </div>
                        </div>
                        `
                    },
                },
                {
                    targets: 2,
                    data: 'rombel_name',
                    render: function(data, type, full, meta) {
                        return full['rombel_name'];
                    },
                },
                {
                    targets: 3,
                    data: 'dudi_name',
                    render: function(data, type, full, meta) {
                        return full['dudi_name'];
                    },
                },
                {
                    targets: 4,
                    data: 'status',
                    render: function(data, type, full, meta) {
                        return full['status'];
                    },
                },
                {
                    targets: -1,
                    width: "50px", // Mengatur lebar kolom nomor urut
                    // data: 'name',
                    render: function(data, type, full, meta) {
                        return full['action'];
                    },
                }
            ]
        });
    }
</script>