<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    var sTabOpen = 'akademik';
    $(() => {
        $('#tanggal_lahir').flatpickr({
            monthSelectorType: 'static',
            dateFormat: 'd-m-Y'
        });
        APP.block();
        initData();
        onShowTab(`<a data-tab="akademik">`);
        initAlamat();

        $('#newPassword').on('input', function() {
            const password = $(this).val();
            const progressBar = $('#progressBar');
            const message = $('#message');
            let strength = 0;

            // Cek panjang password
            if (password.length >= 8) {
                strength++;
            }
            // Cek huruf kapital
            if (/[A-Z]/.test(password)) {
                strength++;
            }
            // Cek simbol
            if (/[\W_]/.test(password)) {
                strength++;
            }

            // Atur lebar progress bar dan pesan
            switch (strength) {
                case 0:
                    progressBar.css('width', '0%');
                    message.text('');
                    break;
                case 1:
                    progressBar.css('width', '33%');
                    progressBar.css('background-color', 'red');
                    message.text('Kekuatan password: Lemah');
                    break;
                case 2:
                    progressBar.css('width', '66%');
                    progressBar.css('background-color', 'orange');
                    message.text('Kekuatan password: Sedang');
                    break;
                case 3:
                    progressBar.css('width', '100%');
                    progressBar.css('background-color', 'green');
                    message.text('Kekuatan password: Kuat');
                    break;
            }
        });

        $('#confirmPassword').on('input', function() {
            const newPassword = $('#newPassword').val();
            const confirmPassword = $(this).val();
            const message = $('#message2');

            if (newPassword !== confirmPassword) {
                message.text('Password tidak cocok!').css('color', 'red');
            } else {
                message.text('Password cocok!').css('color', 'green');
            }
        });
    })

    initData = () => {
        APP.axiosRequest({
            url: `${BASE_API_MENU}/info`,
        }).then(res => {
            $.each(res.data, (i, v) => {
                $(`#info-${i}`).val(v);
                // $(`[name="${i}"]`).val(v);
                let inputElement = $(`[name="${i}"]`);
                inputElement.val(v).trigger('change');

                // Jika elemen memiliki Flatpickr, atur tanggalnya dengan setDate
                if (inputElement.hasClass('flatpickr-input')) {
                    // Konversi format YYYY-MM-DD ke DD-MM-YYYY jika perlu
                    let formattedDate = v.split('-').reverse().join('-');

                    console.log("Setting date:", formattedDate); // Debugging
                    inputElement[0]._flatpickr.setDate(formattedDate, true);
                }
            })

            $.each(res.data, (i, v) => {
                if (i == 'jk') {
                    var v = v == 'L' ? 'LAKI - LAKI' : 'PEREMPUAN';
                    $(`.detail-${i}`).html(v);
                } else if (i == 'is_active') {
                    var v = v ? `<span class="badge bg-success">Aktif</span>` : `<span class="badge bg-danger">Tidak Aktif</span>`
                    $(`.detail-${i}`).html(v);
                } else if (i == 'tanggal_lahir') {
                    var v = moment(v).format('DD MMMM Y');
                    $(`.detail-${i}`).html(v);
                } else {
                    $(`.detail-${i}`).html(v);
                }
            })
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }

    initAlamat = () => {
        var alamat = $('#listAlamatSiswa');
        alamat.html('');
        APP.axiosRequest({
            url: `${BASE_API_MENU}/info`,
            data: {
                'task': 'alamat'
            }
        }).then(res => {
            console.log(res)

            var data = res.data;
            $.each(data, (i, v) => {
                // param = JSON.parse(atob(data));
                params = btoa(JSON.stringify(v));
                var badge = `<span class="badge bg-label-success">Default Address</span>`;
                html = `
                <div class="accordion-item border-bottom">
                    <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="headingHome">
                        <a
                            class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#navtabalamat${i}"
                            aria-expanded="false"
                            aria-controls="headingHome"
                            role="button">
                            <span>
                                <span class="d-flex gap-2 align-items-baseline">
                                    <span class="h6 mb-1">${v.label}</span>
                                    <span class="badge bg-label-success d-none">Default Address</span>
                                </span>
                                <span class="mb-0">${v.kota},${v.provinsi}</span>
                            </span>
                        </a>
                        <div class="d-flex gap-4 p-6 p-sm-0 pt-0 ms-1 ms-sm-0">
                            <a href="javascript:void(0);" onclick="onEditAlamat(this)" data-params="${params}"><i class="ti ti-edit text-body ti-md"></i></a>
                            <a href="javascript:onDeleteAlamat(${v.id});"><i class="ti ti-trash text-body ti-md"></i></a>
                            <button class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                <i class="ti ti-dots-vertical text-body ti-md mt-1"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Set as default address</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="navtabalamat${i}" class="accordion-collapse collapse" data-bs-parent="#ecommerceBillingAccordionAddress">
                        <div class="accordion-body ps-6 ms-1">
                            <p class="mb-1">${v.alamat},</p>
                            <p class="mb-1">${v.desa},${v.kecamatan},${v.kota}</p>
                        </div>
                    </div>
                </div>
                `;
                alamat.append(html)
            })
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }

    onSaveIt = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'save';

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            APP.showToast({
                type: data.status,
                message: data.message,
            });
            if (data.success) {
                initData();
                $('#biodataModal').modal('hide');
            }
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }

    onShowTab = (el) => {
        APP.block();
        var data = $(el).data('tab');
        $(`[data-tab="${sTabOpen}"]`).removeClass('active');
        $(`#page-${sTabOpen}`).fadeOut('slow', () => {
            APP.unblock();
            sTabOpen = data;
            $(`[data-tab="${sTabOpen}"]`).addClass('active');
            $(`#page-${sTabOpen}`).fadeIn();
        });
    }

    onModalBiodata = () => {
        $('#biodataModal').modal('show');
    }

    newAlamat = () => {
        $('#taskIdAlamat').val('');
        $('#label').val('');
        $('#alamat').val('');
        $('#provinsi').val('');
        $('#kota').val('');
        $('#kecamatan').val('');
        $('#desa').val('');
        $('#alamat_utama').prop('checked', false); // Mengatur checkbox menjadi unchecked
        $('#addNewAddress').modal('show');
    }

    onEditAlamat = (el) => {
        var data = $(el).data('params')
        data = JSON.parse(atob(data));
        console.log(data)
        $('#taskIdAlamat').val(data.id);
        $.each(data, (i, v) => {
            $(`[name="${i}"]`).val(v);
        })
        $('#addNewAddress').modal('show');
    }

    onSaveItAlamat = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'save';

        formData.append('task', 'alamat');

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            APP.showToast({
                type: data.status,
                message: data.message,
            });
            if (data.success) {
                initAlamat();
                $('#addNewAddress').modal('hide');
            }
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }

    onPassword = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'save';

        formData.append('task', 'password');

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            APP.showToast({
                type: data.status,
                message: data.message,
            });
            if (data.success) {
                var progressBar = $('#progressBar');
                progressBar.css('width', '0%');
                $('#message').html('')
                $('#message2').html('')
                $('#newPassword').val('');
                $('#confirmPassword').val('');
            }
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }

    onDeleteAlamat = (id) => {
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
                    url: `${BASE_API_MENU}/save`,
                    data: {
                        id: id,
                        task: 'delete'
                    },
                }).then(data => {
                    initAlamat();
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