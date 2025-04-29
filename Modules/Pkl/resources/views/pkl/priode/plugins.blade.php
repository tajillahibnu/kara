<script src="{{asset('/')}}modules/pkl/pkl/priode.js"></script>
<script src="{{asset('/')}}modules/pkl/pkl/priode_jurusan.js"></script>

<script>
    onPageInduka = (el) => {
        var myQueue = new Queue();
        myQueue.enqueue(function(next) {
            APP.block();
            var data = $(el).data('params');
            data = JSON.parse(atob(data));
            targetID = data['id'];
            console.log(data)
            $.each(data, (i, v) => {
                let inputElement = $(`.info-${i}`);
                inputElement.html(v);
            });
            $('.info-tanggal').html(`${moment(data.tanggal_mulai).format('DD MMMM Y')} - ${moment(data.tanggal_selesai).format('DD MMMM Y')}`)
            next()
        }, '1').enqueue(function(next) {
            APP.combov1({
                el: ['#filter_jurusan'],
                url: `${BASE_API_MENU}/combobox/kompt`,
                data: {
                    id: targetID,
                    tipe: 'induka'
                },
                fild_id: 'id',
                fild_name: 'name',
                select2: true,
                choose: false,
                callback: () => {
                    goToPage(`<span data-close="main" data-open="detail">`)
                    next(800)
                }
            })
        }, '2').enqueue(function(next) {
            tableInduka()
            APP.unblock();
        }, 'second').dequeueAll();
    }

    onFilterInduka = (isReset = false) => {
        if (isReset) {
            $('#filter_jurusan').val('').trigger('change');
        }
        tableInduka()
    }

    newInduka = () => {
        var myQueue = new Queue();
        myQueue.enqueue(function(next) {
            APP.block();
            $('#modalInduka').trigger('reset');
            APP.combov1({
                el: ['#select_induka'],
                url: `${BASE_API_MENU}/combobox/induka`,
                data: {
                    id: targetID,
                },
                fild_id: 'id',
                fild_name: 'name',
                select2: true,
                choose: false,
                dropdownParent: '#modalInduka',
                callback: () => {
                    next(800)
                }
            })
        }, 'first').enqueue(function(next) {
            APP.unblock();
            $('#modalInduka').modal('show');
        }, 'second').dequeueAll();
    }


    tableInduka = () => {
        APP.initTable({
            el: '#table-induka',
            url: BASE_API_MENU + '/table-induka',
            data: {
                priode: targetID,
                jurusan: $('#filter_jurusan').val()
            },
            dom: `
            <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
                <"d-flex justify-content-center justify-content-md-end align-items-baseline"
                <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
            <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
            buttons: [{
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Induka</span>',
                className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                action: function(e, dt, node, config) {
                    newInduka()
                },
            }],
            columnDefs: [{
                    targets: 1,
                    data: 'dudi_name',
                    render: function(data, type, full, meta) {
                        return `<div class="d-flex flex-column"><span>${full['dudi_name']}</span></div>`
                    },
                },
                {
                    targets: 2,
                    width: "150px",
                    data: 'jumlah_kuota',
                    render: function(data, type, full, meta) {
                        return full['jumlah_kuota'] + ' Siswa';
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

    onSaveInduka = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'store_induka';
        var jurusan = $('#filter_jurusan').val();

        formData.append('priode_id', targetID)
        formData.append('jurusan', jurusan)

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            APP.reloadTable({
                el: '#table-induka'
            });
            $('#modalInduka').modal('hide');
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

    onDeleteInduka = (el) => {
        var data = $(el).data('params')
        data = JSON.parse(atob(data));
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
                    url: `${BASE_API_MENU}/delete_induka`,
                    data: {
                        id: data['id']
                    },
                }).then(data => {
                    APP.reloadTable({
                        el: '#table-induka'
                    });
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
</script>