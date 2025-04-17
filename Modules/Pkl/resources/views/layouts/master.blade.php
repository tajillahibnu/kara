<!doctype html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
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
        var APP_MODULE = `{{$biodata->slug_module}}`;
        var app_title = `{{ config('app.name', 'Aplikasi') }}`;
    </script>
    <!-- / Layout wrapper -->
    @include('pkl::layouts.plugins')
    <!-- Page JS -->
    <script src="{{asset('/')}}modules/pkl/main.js"></script>
    <div id="content-plugins"></div>
</body>

</html>