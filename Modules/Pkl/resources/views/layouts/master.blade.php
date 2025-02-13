<!doctype html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-semi-dark"
    data-assets-path="{{asset('/')}}assets/"
    data-template="educare"
    data-style="light">

@include('pkl::layouts.head')
<style>
    .length-menu-no-margin .dataTables_length {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    #block-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Transparan hitam */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        /* Pastikan di atas semua elemen lain */
    }

    .spinner-container {
        text-align: center;
        color: white;
        /* Warna teks di bawah spinner */
    }

    .spinner-border {
        width: 8rem;
        height: 8rem;
        border-width: 1rem;
        margin-bottom: 10px;
        /* Jarak antara spinner dan teks */
    }

    #block-loader p {
        margin-top: 10px;
        font-size: 2rem;
        font-weight: 500;
    }
</style>

<body>
    <!-- Overlay (seperti modal) yang akan menutupi halaman saat DataTable sedang memuat -->
    <div id="block-loader" style="display: none;">
        <div class="spinner-container">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading, please wait...</p>
        </div>
    </div>


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('pkl::layouts.nav-menu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('pkl::layouts.nav-head')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div id="content-area">
                            @yield('content')
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by <a href="https://pixinvent.com" target="_blank" class="footer-link">Pixinvent</a>
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank">License</a>
                                    <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4">More Themes</a>

                                    <a
                                        href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
                                        target="_blank"
                                        class="footer-link me-4">Documentation</a>

                                    <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <script>
        var BASE_URL = `{{url('/')}}`;
        var BASE_API_MENU = `${BASE_URL}/api/pkl/`;
    </script>
    <!-- / Layout wrapper -->
    @include('pkl::layouts.plugins')
    <!-- Page JS -->
    <script src="../../assets/js/tables-datatables-basic.js"></script>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let menuLinks = document.querySelectorAll('.main-menu_nav');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah link melakukan navigasi

                // Ambil URL dari data-url attribute
                let url = this.getAttribute('data-url');
                let suburl = this.getAttribute('data-suburl');
                let params = this.getAttribute('data-params');
                // Hapus class 'active' dari semua menu-item dan menu-link
                document.querySelectorAll('.menu-item').forEach(function(item) {
                    item.classList.remove('active', 'open');
                });

                // Tambahkan class 'active' ke submenu yang diklik
                let submenuItem = this.closest('.menu-item');
                submenuItem.classList.add('active');

                $(`[data-url="${suburl}"]`).addClass('active open');

                // let url = 'desk/content';
                $('#content-area').html('');
                // // Axios untuk mengambil konten dari server
                APP.axiosRequest({
                    url: `${BASE_URL}/api/pkl/load-page`,
                    data: {
                        id: url,
                        params: params
                    },
                }).then(response => {
                    var data = response.data;
                    var nameMenu = data['name'];

                    $('#page-menu-name').html(nameMenu)
                    BASE_API_MENU = `${BASE_URL}/api/pkl/${data.url}`;

                    var html = atob(data.html);
                    var plugins = atob(data.plugins);
                    $('#content-area').html(html);
                    $('#content-plugins').html(plugins);
                    // customcard.bindEvents(); // Memanggil ulang event listener
                    $(`[data-url="${url}"]`).addClass('active');
                    // feather.replace();
                }).catch(error => {
                    console.error("Fetch error:", error);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const observer = new MutationObserver(function(mutations) {
                const firstMenu = document.querySelector('.main-menu_nav');
                if (firstMenu) {
                    firstMenu.click(); // Menjalankan klik pada menu pertama
                    observer.disconnect(); // Hentikan observer setelah elemen ditemukan
                    $('#template-customizer').remove();
                }
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
    <div id="content-plugins"></div>
</body>

</html>