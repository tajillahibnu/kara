var acces_role = 'admin';
var access_token = 'admin';
/**
 * Penulisan var APP = ((config) => { ... })(); 
 * adalah contoh dari Immediately Invoked Function Expression (IIFE) dalam JavaScript, 
 * yang sering digunakan untuk membuat modul atau ruang lingkup lokal untuk variabel dan fungsi
 */
var APP = ((config) => {
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.baseURL = '/api'; // Set base URL untuk semua permintaan
    // Pemetaan error kode ke tindakan yang sesuai
    const errorHandlers = {
        401: () => {
            alert("Sesi Anda telah berakhir. Anda akan diarahkan ke halaman login.");
            window.location.reload();
        },
        403: () => alert("Anda tidak memiliki izin untuk mengakses."),
        419: () => {
            alert("Sesi Anda telah kedaluwarsa. Halaman akan dimuat ulang.");
            window.location.reload();
        },
    };
    // Tambahkan interceptor respons Axios untuk menangani status kode otentikasi
    axios.interceptors.response.use(
        function (response) {
            // Jika respons berhasil, langsung kembalikan respons
            return response;
        },
        function (error) {
            // console.log(error)
            if (error.response) {
                const status = error.response.status;

                if (status === 422) {
                    // Menangani error validasi Laravel
                    const errors = error.response.data.errors;
                    if (errors) {
                        // Loop melalui error dan tampilkan toastr untuk setiap pesan
                        Object.keys(errors).forEach(field => {
                            errors[field].forEach(message => toastr.error(message));
                        });
                    } else {
                        // Pesan default jika tidak ada pesan spesifik dari Laravel
                        toastr.error("Data yang Anda masukkan tidak valid. Silakan periksa input Anda.");
                    }
                } else if (errorHandlers[status]) {
                    // Panggil handler untuk status kode yang sesuai
                    errorHandlers[status]();
                } else {
                    // Untuk status error lainnya, tampilkan pesan error default
                    const message = error.response.data.message || "Terjadi kesalahan, silakan coba lagi.";
                    toastr.error(message, `Error ${status}`);
                    // APP.notif({
                    //     type: 'danger',
                    //     message: message,
                    // });
                }
            } else {
                // Untuk error tanpa response dari server
                toastr.error("Gagal terhubung ke server. Silakan coba lagi nanti.");
            }
            return Promise.reject(error);
        }
    );

    return {
        block : () => {
            $('#block-loader').show();
        },
        unblock : () =>{
            $('#block-loader').hide();
        },
        decodeEntities: (encodedString) => {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = encodedString;
            return textArea.value;
        },
        // Fungsi umum untuk permintaan data menggunakan Axios
        axiosRequest: (config) => {
            config = $.extend(true, {
                method: 'post', // Metode default untuk penyimpanan adalah POST
                headers: {},
            }, config);

            if (config.data instanceof FormData) {
                config.headers['Content-Type'] = 'multipart/form-data';
            } else {
                // Jika menggunakan serialize(), konversi data menjadi URL-encoded
                config.data = $.param(config.data);
                config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
            }

            // console.log(config.headers)

            return axios(config)
                .then(response => {
                    // console.log("Response data:", response.data);
                    return response.data;
                })
                .catch(error => {
                    // console.error("Axios Error:", error);
                    throw error;
                });
        },
        // Fungsi untuk menyimpan data, bisa menggunakan method POST
        save: (config) => {
            config = $.extend(true, {
                method: 'post', // Metode default untuk penyimpanan adalah POST
            }, config);

            // console.log("Saving with config:", config);
            return axios.post(config.url, config.data)
                .then(response => {
                    // console.log("Data saved successfully:", response.data);
                    return response.data;
                })
                .catch(error => {
                    // console.error("Error while saving data:", error);
                    throw error;
                });
        },
        initTable: (config) => {
            // Pastikan columnDefs terdefinisi
            if (!config.columnDefs) {
                config.columnDefs = [];
            }

            // Menggabungkan pengaturan default dan pengaturan pengguna
            config = $.extend(true, {
                el: '#maintable',
                el_search: 'search',
                searchPlaceholder: 'Search Data',
                url: null, // URL untuk data server-side
                multiple: false,
                sorting: 'asc',
                index: 1,
                searching: true,
                tabDetails: false,
                responsive: false,
                pageLength: 10,
                mouseover: true,
                stateSave: false,
                destroyAble: true,
                fixedHeader: {
                    header: false,
                    footer: false
                },
                data: {},
                filterColumn: {
                    state: true,
                    exceptionIndex: []
                },
                callbackClick: function () { },
                rawClick: function () { },
                tokenType: 'csrf', // Tambahkan pengaturan untuk menentukan jenis token
                columnDefs: [], // Definisi kolom
                lengthMenu: [5, 10, 25, 50, 100], // Default length menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: 'Search Data',
                    paginate: {
                        next: '<i class="ti ti-chevron-right ti-sm"></i>',
                        previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                    }
                },
            }, config);

            // Pengaturan DataTable
            var defaultSettings = {
                destroy: config.destroyAble,
                responsive: config.responsive,
                lengthMenu: config.lengthMenu,
                pageLength: config.pageLength,
                stateSave: config.stateSave,
                processing: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                language: config.language,
                order: [
                    [config.index, config.sorting]
                ],
                serverSide: !!config.url, // Hanya aktif jika URL server-side diberikan
                ajax: config.url
                    ? {
                        url: config.url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: (d) => {
                            $.extend(d, config.data);
                        },
                        error: (error) => {
                            if (error.status === 401) {
                                location.reload(); // Reload jika tidak terautentikasi
                            }
                        },
                    }
                    : undefined,
                columnDefs: config.columnDefs,
                fnRowCallback: (row, data, index) => {
                    // Tambahkan kolom dengan nilai default jika data kosong
                    $(row).find('td').each(function () {
                        // if (!$(this).text().trim()) {
                        //     $(this).text('-');
                        // }
                    });
                },
                drawCallback: () => {
                    if (typeof config.callbackClick === 'function') {
                        config.callbackClick();
                    }
                },
            };

            config.columnDefs.push({
                targets: 0,
                orderable: false,
                width: "35px", // Mengatur lebar kolom nomor urut
                render: function (data, type, full, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            });

            // Inisialisasi DataTable
            var dt = $(config.el).DataTable($.extend(true, defaultSettings, config));

            // Penanganan pencarian custom
            // setTimeout(() => {
            //     if (config.searching) {
            //         const filterSearch = document.querySelector(`[data-kt-filter="${config.el_search}"]`);
            //         filterSearch.addEventListener('keypress', function (e) {
            //             if (e.key === 'Enter') {
            //                 dt.search(e.target.value).draw();
            //             }
            //         });
            //     }
            // }, 500);

            return dt;
        },
        // Fungsi untuk mereload DataTable
        reloadTable: (config) => {
            config = $.extend(true, {
                el: '#maintable',
                // tambahkan default URL jika diperlukan
            }, config);

            // Ambil instance DataTable berdasarkan elemen yang diberikan
            var dataTable = $(config.el).DataTable();

            // Atur ulang URL hanya jika berbeda dari konfigurasi awal
            if (config.url && dataTable.ajax.url() !== config.url) {
                dataTable.ajax.url(config.url).load(null, false); // set URL dan reload tanpa ganti halaman
            } else {
                dataTable.ajax.reload(null, false); // reload data tanpa ganti halaman
            }

        },
        // Fungsi untuk menghancurkan DataTable
        destroyTable: (config) => {
            config = $.extend(true, {
                el: '#maintable',
            }, config);

            // Pastikan DataTable ada sebelum mencoba menghancurkannya
            if ($.fn.DataTable.isDataTable(config.el)) {
                var dataTable = $(config.el).DataTable();
                dataTable.clear().destroy(); // Hancurkan tabel dan hapus data
                // console.log("DataTable destroyed.");
            } else {
                // console.warn("DataTable not initialized, cannot destroy.");
            }
        },
        confirm: (config) => {
            // Menggabungkan konfigurasi default dengan konfigurasi yang diberikan
            config = $.extend(
                true,
                {
                    title: 'Confirmation',
                    text: "Do you want to proceed?",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light text-white',
                        cancelButton: 'btn btn-outline-secondary waves-effect'
                    },
                    buttonsStyling: false,
                },
                config
            );
            // Mengembalikan promise untuk mendukung penggunaan .then di luar
            return Swal.fire(config);
        },
        combov1: (config) => {
            config = $.extend(true, {
                el: ['#comboId'],
                url: BASE_URL,
                data: {},
                method: "post",
                fild_id: '',
                fild_name: '',
                selected: '',
                dropdownParent: '',
                placeholder: 'Select value',
                custom: false,
                autoselect: true,
                select2: false,
                callback: () => { }
            }, config);

            config.el.forEach(selector => {
                $(selector).empty().append('<option disabled="" value="">Choose...</option>');
            });

            APP.axiosRequest({
                url: config.url,
                data: config.data,
            }).then(response => {
                const data = response.data;
                config.el.forEach(selector => {
                    data.forEach(item => {
                        const optionText = Array.isArray(config.fild_name)
                            ? config.fild_name.map(f => item[f]).join(' ')
                            : item[config.fild_name];

                        $(selector).append(`<option value="${item[config.fild_id]}">${optionText}</option>`);
                    });

                    // Auto-select opsi pertama jika config.autoselect diaktifkan
                    if (config.autoselect && data.length > 0) {
                        $(selector).val(data[0][config.fild_id]).trigger('change');
                    }

                    // Jika custom select2 diaktifkan, lakukan inisialisasi select2
                    if (config.select2) {
                        $(selector).select2({
                            placeholder: config.placeholder,
                            dropdownParent: config.dropdownParent ? $(config.dropdownParent) : undefined
                        });
                    }
                });
                if (typeof config.callback === "function") {
                    config.callback({ success: true, data }); // Callback untuk data yang diterima
                }

            }).catch(error => {
                console.error("Fetch error:", error);

                // Tambahkan opsi error jika gagal
                config.el.forEach(selector => {
                    const $select = $(selector);
                    if ($select.length > 0) {
                        $select.append('<option disabled value="">Error fetching data</option>');
                    }
                });

                // Panggil callback dengan error jika ada
                if (typeof config.callback === "function") {
                    config.callback({ success: false, error }); // Callback untuk error
                }

            });
        },
        showToast: (config) => {
            // Default konfigurasi
            const defaultConfig = {
                type: 'info', // Jenis notifikasi: success, info, warning, error
                message: 'This is a default message.',
                title: '',
                options: {
                    closeButton: true,
                    progressBar: true,
                    // positionClass: 'toast-top-right', // Posisi
                    timeOut: 3000, // Waktu tampil dalam milidetik
                    extendedTimeOut: 1000, // Waktu tampil tambahan
                    showDuration: 300, // Durasi muncul
                    hideDuration: 300, // Durasi hilang
                    onclick: null, // Fungsi callback saat diklik
                }
            };

            // Gabungkan default config dengan config pengguna
            config = Object.assign({}, defaultConfig, config);

            // Set opsi toastr
            toastr.options = config.options;

            // Tampilkan notifikasi berdasarkan jenis
            switch (config.type) {
                case 'success':
                    toastr.success(config.message, config.title);
                    break;
                case 'error':
                    toastr.error(config.message, config.title);
                    break;
                case 'warning':
                    toastr.warning(config.message, config.title);
                    break;
                case 'info':
                default:
                    toastr.info(config.message, config.title);
                    break;
            }
        },
        notif: (config) => {
            config = $.extend(true, {
                el: '#liveToast6',
                type: 'success',
                message: 'N/A'
            }, config);

            if (config.type == 'error') {
                config.type = 'dangger';
            }

            var html = `
            <div class="card-body common-flex common-toasts">
                <div class="toast-container position-fixed top-0 end-0 p-3 toast-index toast-rtl">
                    <div class="toast" id="liveToast6" role="alert" aria-live="polite" aria-atomic="true">
                        <div class="common-space alert-light-${config.type}">
                            <div class="toast-body">
                                <i class="fa-regular fa-bell stroke-success" data-feather="check-square"></i>${config.message}
                            </div>
                            <button class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>`;

            $('#notif-app').html(html);
            const toastLiveExample = $(config.el)
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
            toastBootstrap.show()
            // setTimeout(() => {
            // }, 400);
        },
        // notify: (config) => {
        //     // Opsi default
        //     var defaults = {
        //         type: 'theme', // success, danger, warning, info
        //         message: '<i class="fa-regular fa-bell"></i><strong>Notification</strong> Default message.',
        //         delay: 2000,
        //         allow_dismiss: true,
        //         timer: 300,
        //         animate: {
        //             enter: "animated fadeInDown",
        //             exit: "animated fadeOutUp",
        //         },
        //         showProgressbar: true,
        //     };

        //     // Menggabungkan konfigurasi dengan default
        //     config = $.extend(true, defaults, config);

        //     // Menampilkan notifikasi
        //     $.notify(config.message, {
        //         type: config.type,
        //         allow_dismiss: config.allow_dismiss,
        //         delay: config.delay,
        //         animate: config.animate,
        //         showProgressbar: config.showProgressbar,
        //     });
        // }
    };
})({ defaultOption: true }); // Mengirimkan objek config saat IIFE dipanggil

getInitials = (name) => {
    // Pecah nama berdasarkan spasi
    let words = name.trim().split(/\s+/); 
    
    // Jika hanya ada satu kata, gunakan huruf pertama dari kata tersebut
    if (words.length === 1) {
        return words[0].charAt(0).toUpperCase();
    }
    
    // Ambil dua nama depan pertama dan buat inisialnya
    let initials = words[0].charAt(0).toUpperCase() + words[1].charAt(0).toUpperCase();
    
    return initials;
}


class Queue {
    constructor() {
        this.queue = [];
        this.isRunning = false;
    }

    enqueue(callback, delay = 0) {
        this.queue.push({ callback, delay });
        return this;
    }

    dequeue() {
        if (this.queue.length === 0) {
            this.isRunning = false;
            return;
        }

        this.isRunning = true;
        const { callback, delay } = this.queue.shift();

        setTimeout(() => {
            callback(() => this.dequeue());
        }, delay);
    }

    dequeueAll() {
        if (!this.isRunning) {
            this.dequeue();
        }
    }

    clearQueue() {
        this.queue = [];
        this.isRunning = false;
    }
}
