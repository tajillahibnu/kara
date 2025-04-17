<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var tanggalMulaiPicker, tanggalSelesaiPicker;
    var isFlatpickrInitialized = false;
    var targetID = '';

    $(() => {
        mainTable()
    })

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            columnDefs: [{
                    targets: 0,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: 1,
                    data: 'tanggal_mulai',
                    className: 'column-top',
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
                                    <small class="text-truncate">${full['nis']}</small>
                                </div>
                            </div>`
                    },
                },
                {
                    targets: 2,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return `
                            <div class="d-flex justify-content-left align-items-center">
                                <div class="d-flex flex-column">
                                    <h6 class="text-truncate mb-0">${full['tanggal_range']}</h6>
                                    <small class="text-truncate">Status : ${full['status_guru_pembimbing']}</small>
                                </div>
                            </div>`
                    },
                },
                {
                    targets: 3,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['note']
                    },
                },
                {
                    targets: -1,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['action'];
                    },
                },
            ]
        }).on('draw.dt', function() {
            APP.toggleReadMore({
                el: '.column-deskripsi',
                text: {
                    more: 'Lihat lebih',
                    less: 'Tutup'
                },
                onToggle: function(status, el) {
                    // console.log('Toggle status:', status);
                }
            });
        });;
    }

    function hitungSelisihHari(tanggalMulaiPicker, tanggalSelesaiPicker) {
        // Mengonversi tanggal ke objek moment
        const mulaiDate = moment(tanggalMulaiPicker);
        const selesaiDate = moment(tanggalSelesaiPicker);

        if (mulaiDate.isValid() && selesaiDate.isValid()) {
            // Hitung selisih (dalam milidetik), lalu ubah ke hari
            const diffTime = selesaiDate.diff(mulaiDate); // Menggunakan method diff dari moment.js
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 agar tgl yg sama = 1 hari

            if (diffDays >= 1) {
                $(".info-selisih_hari").html(`${diffDays} hari`);
            } else {
                $(".info-selisih_hari").html("0 hari");
            }
        } else {
            $(".info-selisih_hari").html("x hari");
        }
    }

    confirm = (el) => {
        var tipe = $(el).data('tipe')
        APP.confirm({
            title: 'Are you sure?',
            text: tipe == 'completed' ? 'Apakah anda ingin menyetujui ketidak hadiran siswa?' : 'Apakah anda ingin membatalkan ketidak hadiran siswa',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: tipe == 'completed' ? 'Setujui!' : 'Tolak!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: tipe == 'completed' ? 'btn btn-primary waves-effect waves-light text-white' : 'btn btn-danger waves-effect waves-light text-white',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                APP.axiosRequest({
                    url: `${BASE_API_MENU}/confirm`,
                    data: {
                        id: targetID,
                        tipe: tipe,
                    },
                }).then(data => {
                    APP.reloadTable();
                    APP.showToast({
                        type: data.status,
                        message: data.message,
                    });
                    $('#mainModal').modal('hide');
                }).catch(error => {
                    console.error("Fetch error:", error);
                });
            }
        });
    }

    onView = (el) => {
        var data = $(el).data('params');
        data = JSON.parse(atob(data));
        targetID = data['id']
        var tanggalMulaiPicker = '';
        var tanggalSelesaiPicker = '';
        $('#box-konfirmasi').html('');

        $.each(data, (i, v) => {
            if (i == 'tanggal_mulai') {
                tanggalMulaiPicker = v;

            } else if (i === 'tanggal_selesai') {
                tanggalSelesaiPicker = v;
            }
            let inputElement = $(`.info-${i}`);
            inputElement.html(v);
        })

        $('#box-konfirmasi').html(data.btnProgress);
        setTimeout(() => {
            hitungSelisihHari(tanggalMulaiPicker, tanggalSelesaiPicker)
            $('#mainView').modal('show');
        }, 500);

    }
</script>