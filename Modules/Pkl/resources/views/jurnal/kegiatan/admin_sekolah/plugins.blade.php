<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var targetID = '';
    $(() => {
        mainTable()
    })

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            index: 1,
            columnDefs: [{
                    targets: 0,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: 1,
                    data: 'tanggal_range',
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['tanggal_range'];
                    },
                },
                {
                    targets: 2,
                    name: 'kegiatan',
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['kegiatan']
                    },
                },
                {
                    targets: 3,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['jam']
                    },
                },
                {
                    targets: 4,
                    width: "50px",
                    data: 'deskripsi',
                    name: 'deskripsi',
                    className: 'column-deskripsi',
                    render: function(data, type, full, meta) {
                        return full['deskripsi'];
                    },
                },
                {
                    targets: -1,
                    width: "50px",
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['action'];
                    },
                }
            ]
        });
    }
</script>