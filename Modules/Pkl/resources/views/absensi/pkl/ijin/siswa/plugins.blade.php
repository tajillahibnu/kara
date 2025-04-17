<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var tanggalMulaiPicker, tanggalSelesaiPicker;
    var isFlatpickrInitialized = false;

    $(() => {
        initializePickers()
        mainTable()

        const textarea = document.getElementById('alasan');
        const counter = document.getElementById('alasan-counter');
        const maxLength = 1000;

        function updateCounter() {
            const length = textarea.value.length;
            counter.textContent = `${length} / ${maxLength} karakter`;
            if (length > maxLength) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
            }
        }

        updateCounter();
        textarea.addEventListener('input', updateCounter);

    })

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            dom: `
                <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
                    <"d-flex justify-content-center justify-content-md-end align-items-baseline"
                    <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
                <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
            buttons: [{
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Tambah</span>',
                className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                action: function(e, dt, node, config) {
                    newData()
                },
            }],
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
                        return full['tanggal_range']
                    },
                },
                {
                    targets: 2,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return full['note'];
                    },
                },
                {
                    targets: 3,
                    className: 'column-top',
                    render: function(data, type, full, meta) {
                        return `
                        <div class="d-flex justify-content-left align-items-center">
                            <table>
                                <tr>
                                    <td style="padding-top: 5px;vertical-align: top;padding-left:0px;"><span class="fw-medium">Status Pembimbing</span></td>
                                    <td style="padding-top: 5px;vertical-align: top;"><span class="fw-medium">:</span></td>
                                    <td style="padding-top: 5px;vertical-align: top;" class="px-2"> ${full['status_pembimbing_instansi']}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 5px;vertical-align: top;padding-left:0px;"><span class="fw-medium">Status Guru Pembimbing</span></td>
                                    <td style="padding-top: 5px;vertical-align: top;"><span class="fw-medium">:</span></td>
                                    <td style="padding-top: 5px;vertical-align: top;" class="px-2"> ${full['status_guru_pembimbing']}</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 5px;vertical-align: top;padding-left:0px;"><span class="fw-medium">Lampiran</span></td>
                                    <td style="padding-top: 5px;vertical-align: top;"><span class="fw-medium">:</span></td>
                                    <td style="padding-top: 5px;vertical-align: top;" class="px-2"> ${full['lampiran']}</td>
                                </tr>
                            </table>
                        </div>
                        `
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

    newData = () => {
        targetID = '';
        if (tanggalMulaiPicker) tanggalMulaiPicker.clear();
        if (tanggalSelesaiPicker) tanggalSelesaiPicker.clear();
        $('#formMain').trigger('reset');
        $('#mainModal').modal('show');
        APP.characterCounter({
            textareaId: 'alasan',
            counterId: 'alasan-counter',
            maxLength: 1000
        });
    }

    onEdit = (el) => {
        var data = $(el).data('params')
        data = JSON.parse(atob(data));
        targetID = data['id'];

        if (tanggalMulaiPicker) {
            tanggalMulaiPicker.clear();
            tanggalMulaiPicker.set('maxDate', null); // Reset maxDate
        }
        if (tanggalSelesaiPicker) {
            tanggalSelesaiPicker.clear();
            tanggalSelesaiPicker.set('minDate', null); // Reset minDate
        }


        $('#mainModal').modal('show');

        setTimeout(() => {
            $.each(data, (i, v) => {
                let inputElement = $(`[name="${i}"]`);
                inputElement.val(v).trigger('change');
                if (inputElement.hasClass('flatpickr-input')) {
                    let tanggal = v.split('-').reverse().join('-');
                    let final = `${tanggal}`;
                    inputElement[0]._flatpickr.setDate(final, true);
                }
            });
            APP.characterCounter({
                textareaId: 'alasan',
                counterId: 'alasan-counter',
                maxLength: 1000
            });
        }, 200);
    }


    function initializePickers() {
        if (isFlatpickrInitialized) return;

        tanggalSelesaiPicker = flatpickr("#tanggal_selesai", {
            // defaultDate: today,
            dateFormat: "d-m-Y",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    tanggalMulaiPicker.set("maxDate", selectedDates[0]);

                    // Cek apakah tanggal mulai lebih dari tanggal selesai
                    const mulaiDate = tanggalMulaiPicker.selectedDates[0];
                    if (mulaiDate && mulaiDate > selectedDates[0]) {
                        tanggalMulaiPicker.clear();
                    }
                }
                hitungSelisihHari();
            },
        });

        // Inisialisasi tanggal mulai
        tanggalMulaiPicker = flatpickr("#tanggal_mulai", {
            // defaultDate: today,
            dateFormat: "d-m-Y",
            maxDate: function() {
                const val = document.getElementById("tanggal_selesai").value;
                return val ? flatpickr.parseDate(val, "d-m-Y") : null;
            },
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    tanggalSelesaiPicker.set("minDate", selectedDates[0]);

                    const selesaiDate = tanggalSelesaiPicker.selectedDates[0];
                    if (selesaiDate && selesaiDate < selectedDates[0]) {
                        tanggalSelesaiPicker.clear();
                    }
                }
                hitungSelisihHari();
            },
        });


        isFlatpickrInitialized = true;
    }

    function hitungSelisihHari() {
        const mulaiDate = tanggalMulaiPicker.selectedDates[0];
        const selesaiDate = tanggalSelesaiPicker.selectedDates[0];

        if (mulaiDate && selesaiDate) {
            // Hitung selisih (dalam milidetik), lalu ubah ke hari
            const diffTime = selesaiDate - mulaiDate;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 agar tgl yg sama = 1 hari

            if (diffDays >= 1) {
                document.getElementById("selisih_hari").value = diffDays + " hari";
            } else {
                document.getElementById("selisih_hari").value = "0 hari";
            }
        } else {
            document.getElementById("selisih_hari").value = "";
        }
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
                    APP.notif({
                        type: data.status,
                        message: data.message,
                    });
                }).catch(error => {
                    console.error("Fetch error:", error);
                });
            }
        });

    }

    onView = (el) => {
        var data = $(el).data('params');
        data = JSON.parse(atob(data));
        $.each(data, (i, v) => {
            let inputElement = $(`.info-${i}`);
            inputElement.html(v);
        })

        $('#mainView').modal('show');
    }
</script>