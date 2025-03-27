<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var targetID = '';
    $(() => {
        APP.block();
        $('.form-date').flatpickr({
            dateFormat: 'd-m-Y',
            defaultDate: new Date()
        });
        $('.select2').select2({
            placeholder: 'Select status',
            allowClear: true,
            minimumResultsForSearch: -1,
        });
        combo()
        setTimeout(() => {
            onFilter()
            APP.unblock();
        }, 400);
    })

    combo = () => {
        APP.combov1({
            el: ['#filter_jurusan'],
            url: `${BASE_API_MENU}/combo/jurusan`,
            fild_id: 'id',
            fild_name: 'name',
            select2: true,
            allowClear: false,
            callback: (item) => {
                var options = $('#filter_jurusan option');
                if (options.length > 0) {
                    // var firstOptionValue = options.first().val(); // Ambil nilai opsi pertama
                    var secondOptionValue = options.eq(1).val(); // Ambil nilai opsi kedua
                    $('#filter_jurusan').val(secondOptionValue).trigger('change'); // Set nilai yang dipilih
                }
                // $('#filter_jurusan').val(null).trigger('change');
            }
        })
        APP.combov1({
            el: ['#filter_industri'],
            url: `${BASE_API_MENU}/combo/dudi`,
            fild_id: 'id',
            fild_name: 'name',
            select2: true,
            choose: true,
            callback: (item) => {
                $('#filter_industri').val(null).trigger('change');
                $('#dudi_id').empty().append('<option value="">Choose...</option>');
                item['data'].forEach(element => {
                    $('#dudi_id').append(`<option value="${element['id']}">${element['name']}</option>`);
                });
                $("#dudi_id").select2({
                    allowClear: true,
                    placeholder: "Pilih Industri",
                    dropdownParent: '#mainModal'
                });
            }
        })
        APP.combov1({
            el: ['#filter_priode'],
            url: `${BASE_API_MENU}/combo/priode_pkl_all`,
            fild_id: 'id',
            fild_name: 'name',
            select2: true,
            callback: (item) => {
                $('#filter_priode').val(null).trigger('change');
            }
        })
        APP.combov1({
            el: ['#pegawai_id'],
            url: `${BASE_API_MENU}/combo/pegawai`,
            fild_id: 'id',
            fild_name: 'name',
            select2: true,
            dropdownParent: '#mainModal',
            data: {
                status_kepegawaian: 'PNS',
                jabatan: 'guru',
            },
            callback: (item) => {
                $('#pegawai_id').val(null).trigger('change');
            }
        })
    }

    onFilter = (isReset = false) => {
        if (isReset) {
            $('#filter_priode').val(null).trigger('change');
            $('#filter_industri').val(null).trigger('change');
        }
        mainTable()
    }

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            index: 1,
            data: {
                status: $('#filter_status').val(),
                jurusan: $('#filter_jurusan').val(),
                dudi: $('#filter_industri').val(),
                priode: $('#filter_priode').val(),
            },
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
                                <small class="text-truncate">${full['nis']} [${full['rombel_name']}]</small>
                            </div>
                        </div>
                        `
                    },
                },
                {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return `
                            <div class="d-flex justify-content-left align-items-center">
                                <div class="d-flex flex-column">
                                    <h6 class="text-truncate mb-0">${full['dudi_name']}</h6>
                                    <small class="text-truncate">${full['pembina_name']} [${full['pembina_hp']}]</small>
                                </div>
                            </div>
                        `
                    },
                },
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return `
                            <div class="d-flex justify-content-left align-items-center">
                                <div class="d-flex flex-column">
                                    <h6 class="text-truncate mb-0">${full['guru_name']}</h6>
                                    <small class="text-truncate">${full['guru_nip']}</small>
                                </div>
                            </div>
                        `
                    },
                },
                {
                    targets: 4,
                    width: "50px",
                    render: function(data, type, full, meta) {
                        return full['status'];
                    },
                },
                {
                    targets: -1,
                    width: "50px",
                    render: function(data, type, full, meta) {
                        return full['action'];
                    },
                }
            ]
        });
    }

    onEdit = (el) => {
        var data = $(el).data('params')
        data = JSON.parse(atob(data));
        targetID = data['id'];
        console.log(data)
        $('#dudi_id').val(null).trigger('change'); // Menghapus pilihan
        $.each(data, (i, v) => {
            let inputElement = $(`[name="${i}"]`);
            if (i === 'dudi_id' || i === 'pegawai_id') {
                inputElement.val(v).trigger('change'); // Set nilai yang dipilih
            } else {
                inputElement.val(v).trigger('change');
                // Jika elemen memiliki Flatpickr, atur tanggalnya dengan setDate
                if (inputElement.hasClass('flatpickr-input')) {
                    // Konversi format YYYY-MM-DD ke DD-MM-YYYY jika perlu
                    let formattedDate = v.split('-').reverse().join('-');

                    console.log("Setting date:", formattedDate); // Debugging
                    inputElement[0]._flatpickr.setDate(formattedDate, true);
                }
            }
        })
        $('#mainModal').modal('show');
    }

    onSaveIt = (name) => {
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'store';

        formData.append('taskID', targetID)

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            APP.reloadTable();
            $('#mainModal').modal('hide');
            APP.notif({
                type: data.status,
                message: data.message,
            });
        }).catch(error => {
            console.error("Fetch error:", error);
        });
    }
</script>