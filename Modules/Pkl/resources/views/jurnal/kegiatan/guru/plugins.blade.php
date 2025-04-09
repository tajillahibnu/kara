<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var targetID = '';
    var tanggalMulaiPicker, tanggalSelesaiPicker;
    var isFlatpickrInitialized = false;
    var quillDeskripsi = null;

    $(() => {
        initQuillEditor()
        initializePickers()
        mainTable()
    })

    newData = () => {
        targetID = '';

        if (tanggalMulaiPicker) tanggalMulaiPicker.clear();
        if (tanggalSelesaiPicker) tanggalSelesaiPicker.clear();

        // Hanya reset jika Quill sudah ada dan siap
        if (quillDeskripsi && quillDeskripsi.root) {
            quillDeskripsi.setContents([]);
            $('#deskripsi').val('');
        }


        $('#formMain').trigger('reset');
        $('#mainModal').modal('show');
    }

    editData = (el) => {
        const data = JSON.parse(atob($(el).data('params')));
        targetID = data['id'];
        $('#mainModal').modal('show');

        setTimeout(() => {
            $.each(data, (i, v) => {
                let inputElement = $(`[name="${i}"]`);
                if (i === 'deskripsi' && quillDeskripsi) {
                    quillDeskripsi.root.innerHTML = v || '';
                    $('#deskripsi').val(v);
                } else {
                    inputElement.val(v).trigger('change');

                    if (inputElement.hasClass('flatpickr-input')) {
                        let datetime = v.split(' ');
                        let tanggal = datetime[0].split('-').reverse().join('-');
                        let waktu = datetime[1].substring(0, 5);
                        let final = `${tanggal} ${waktu}`;
                        inputElement[0]._flatpickr.setDate(final, true);
                    }
                }
            });
        }, 200);
    }



    onSaveIt = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = targetID == '' ? 'store' : 'update/' + targetID;
        const content = quillDeskripsi.root.innerHTML;
        formData.append('deskripsi', content)

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

    function initializePickers() {
        if (isFlatpickrInitialized) return;

        tanggalMulaiPicker = flatpickr("#tanggal_mulai", {
            enableTime: true,
            time_24hr: true,
            maxDate: "today",
            dateFormat: "d-m-Y H:i",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    tanggalSelesaiPicker.set('minDate', selectedDates[0]);
                    const selesaiDate = tanggalSelesaiPicker.selectedDates[0];
                    if (selesaiDate && selesaiDate < selectedDates[0]) {
                        tanggalSelesaiPicker.clear();
                    }
                }
            }
        });

        tanggalSelesaiPicker = flatpickr("#tanggal_selesai", {
            enableTime: true,
            time_24hr: true,
            dateFormat: "d-m-Y H:i",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    tanggalMulaiPicker.set('maxDate', selectedDates[0]);
                    const mulaiDate = tanggalMulaiPicker.selectedDates[0];
                    if (mulaiDate && mulaiDate > selectedDates[0]) {
                        tanggalMulaiPicker.clear();
                    }
                }
            }
        });

        isFlatpickrInitialized = true;
    }

    function initQuillEditor() {
        // Jika instance sebelumnya ada, hapus editor dan bersihkan DOM
        if (quillDeskripsi) {
            quillDeskripsi.root.innerHTML = ''; // bersihkan konten
            quillDeskripsi = null;
            document.getElementById('editorDeskripsi').innerHTML = ''; // buang container editor
        }

        // Tambahkan kembali DOM editor
        const editorContainer = document.getElementById('editorDeskripsi');
        const newEditor = document.createElement('div');
        newEditor.style.height = '200px';
        editorContainer.appendChild(newEditor);

        // Inisialisasi ulang Quill
        quillDeskripsi = new Quill(newEditor, {
            theme: 'snow',
            placeholder: 'Tulis catatan...',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['clean']
                ]
            }
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

    mainTable = () => {
        APP.initTable({
            el: '#maintable',
            url: BASE_API_MENU + '/main-table',
            index: 1,
            dom: `
                <"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"<f>
                    <"d-flex justify-content-center justify-content-md-end align-items-baseline"
                    <"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"B>>>t
                <"row mx-1"<"col-sm-12 col-md-6 d-flex align-items-center length-menu-no-margin"li><"col-sm-12 col-md-6"p>>`,
            buttons: [{
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Tambah Data</span>',
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