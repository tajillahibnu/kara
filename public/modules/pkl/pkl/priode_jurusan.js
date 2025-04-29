onViewKompt = (el) => {
    var myQueue = new Queue();
    myQueue.enqueue(function (next) {
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
    }, 'first').enqueue(function (next) {
        goToPage(`<span data-close="main" data-open="kompt">`)
        next(800)
    }, 'first').enqueue(function (next) {
        tableKompt()
        APP.unblock();
    }, 'second').dequeueAll();
}

onDetails = (el) => {
    var data = $(el).data('params');
    data = JSON.parse(atob(data));
    targetID = data['id'];
    console.log(data)
    $.each(data, (i, v) => {
        let inputElement = $(`.info-${i}`);
        inputElement.html(v);
    });

    $('.info-tanggal').html(`${moment(data.tanggal_mulai).format('DD MMMM Y')} - ${moment(data.tanggal_selesai).format('DD MMMM Y')}`)

    goToPage(`<span data-close="main" data-open="detail">`)
}

goToPage = (el) => {
    var data = $(el).data();
    $(`#page-${data['close']}`).fadeOut('slow', () => {
        $(`#page-${data['open']}`).fadeIn();
    });
}

newKompt = () => {
    var myQueue = new Queue();
    myQueue.enqueue(function (next) {
        APP.block();
        $('#formNewKompt').trigger('reset');
        APP.combov1({
            el: ['#select_kompt'],
            url: `${BASE_API_MENU}/combobox/kompt`,
            data: {
                id: targetID,
            },
            fild_id: 'id',
            fild_name: 'name',
            select2: true,
            choose: false,
            dropdownParent: '#modalKompt',
            callback: () => {
                next(800)
            }
        })
    }, 'first').enqueue(function (next) {
        APP.unblock();
        $('#modalKompt').modal('show');
    }, 'second').dequeueAll();
}

onSaveKompt = (name) => {
    APP.block();
    var form = $(`#${name}`)[0];
    var formData = new FormData(form);
    var action = 'store_kompt';

    formData.append('priode_id', targetID)

    APP.axiosRequest({
        url: `${BASE_API_MENU}/${action}`,
        data: formData,
    }).then(data => {
        APP.reloadTable({
            el: '#table-kompt'
        });
        $('#modalKompt').modal('hide');
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


tableKompt = () => {
    APP.initTable({
        el: '#table-kompt', // ID atau kelas elemen tabel HTML
        url: BASE_API_MENU + '/table-priodekompt', // URL endpoint API untuk mengambil data
        data: {
            priode: targetID
        },
        dom: `
            <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
                <"d-flex justify-content-center justify-content-md-end align-items-baseline"
                <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
            <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
        buttons: [{
            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Jurusan</span>',
            className: "add-new btn btn-primary ms-2 waves-effect waves-light",
            action: function (e, dt, node, config) {
                newKompt()
            },
        }],
        columnDefs: [{
            targets: 1,
            data: 'name',
            render: function (data, type, full, meta) {
                return `
                <div class="d-flex flex-column">
                    <span>${full['jurusan_name']}</span>
                </div>
                `
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

onDeleteKompt = (el) => {
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
                url: `${BASE_API_MENU}/delete_kompt`,
                data: {
                    id: data['id']
                },
            }).then(data => {
                APP.reloadTable({
                    el: '#table-kompt'
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