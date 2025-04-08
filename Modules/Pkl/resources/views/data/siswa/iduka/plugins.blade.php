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
                            <small class="text-truncate">${full['nis'] == null ? '[-]' : full['nis']}</small>
                        </div>
                    </div>
                    `
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full['jk'] == 'L'? 'LAKI - LAKI' : 'PEREMPUAN';
                    },
                },
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return full['email'];
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