<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    $(() => {
        $('#title-date').html(`<h4 class="mb-2">${moment().format('MMMM Do YYYY, H:mm')}</h4>`);
        initPage()
    })

    initPage = () => {
        APP.block();
        APP.axiosRequest({
            url: `${BASE_API_MENU}/read`,
        }).then(res => {
            console.log(res.data)
            $.each(res.data, (i, v) => {
                if (i === 'clock_in_real' || i === 'clock_out_real') {
                    if (v === null) {
                        $(`.info-${i}`).html('00:00');
                    } else {
                        $(`.info-${i}`).html(moment(v).format('H:mm'));
                    }
                } else if (i === 'durasi_real') {
                    $(`.info-${i}`).html(formatDuration(v));
                } else {
                    $(`.info-${i}`).html(v);
                }
            })
            if (res.data.clock_in_real === null) {
                $(`#btnAction`).html(`<button type="button" class="btn btn-primary" onclick="onNew('in')">Clock In</button>`);
            } else {
                if (res.data.clock_out_real === null) {
                    $(`#btnAction`).html(`<button type="button" class="btn btn-primary" onclick="onNew('out')">Clock Out</button>`);
                } else {
                    $(`#btnAction`).html(``);
                }
            }
            mainTable()
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
        });
    }

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            order: [
                [1, 'DESC']
            ],
            columnDefs: [{
                    targets: 1,
                    data: 'tanggal',
                    render: function(data, type, full, meta) {
                        return moment(full['tanggal']).format('DD MMM Y');
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full['clock_in_real'] == null ? '-' : moment(full['clock_in_real']).format('H:mm');
                    },
                },
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return full['clock_out_real'] == null ? '-' : moment(full['clock_out_real']).format('H:mm');
                    },
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        return full['clock_out_real'] == null ? '-' : formatDuration(full['durasi_real']);
                    },
                },
            ]
        });
    }

    onNew = (tipe) => {
        if (tipe === 'in') {
            $('#title-form').html(`Clock In`)
        } else {
            $('#title-form').html(`Clock Out`)
        }
        $('#waktu').val(`${moment().format('H:mm')}`)
        $('#mainModal').modal('show');
    }

    onSaveIt = (name) => {
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'chekinout';

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            initPage();
            $('#mainModal').modal('hide');
            APP.showToast({
                type: data.status,
                message: data.message,
            });

        }).catch(error => {
            console.error("Fetch error:", error);
        });
    }

    function formatDuration(minutes) {
        // Menghitung jumlah jam dan sisa menit
        const hours = Math.floor(minutes / 60);
        const remainingMinutes = minutes % 60;

        // Menyusun string hasil
        let result = '';

        if (hours > 0) {
            result += hours + ' jam';
        }

        if (remainingMinutes > 0) {
            if (result) {
                result += ' '; // Menambahkan spasi jika ada jam
            }
            result += remainingMinutes + ' menit';
        }

        // Jika tidak ada jam dan menit, kembalikan '0 menit'
        return result || '0 menit';
    }
</script>