<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                        fill="#161616" />
                    <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                        fill="#161616" />
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Forms & Tables -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="App Menu">App Menu</span>
        </li>
        <!-- Tables -->
        @foreach ($menus as $menu)
        @empty($menu->sub_menu)
        <li class="menu-item">
            <a class="menu-link main-menu_nav" href="javascript:void(0)" data-url="{{$menu->url}}" data-suburl="" data-params="{{base64_encode(json_encode($menu, JSON_PRETTY_PRINT))}}">
                <i class="menu-icon tf-icons ti ti-lifebuoy"></i>
                <div data-i18n="{{$menu->name}}">{{$menu->name}}</div>
            </a>
        </li>
        @else
        <li class="menu-item" data-url="{{$menu->url}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="{{$menu->name}}">{{$menu->name}}</div>
                <!-- <div class="badge bg-danger rounded-pill ms-auto">5</div> -->
            </a>
            <ul class="menu-sub">
                @foreach ( $menu->sub_menu as $subMenu)
                <li class="menu-item">
                    <a class="menu-link main-menu_nav" href="javascript:void(0)" class="main-menu_nav" data-suburl="{{$menu->url}}" data-url="{{$subMenu->url}}" data-params="{{base64_encode(json_encode($subMenu, JSON_PRETTY_PRINT))}}">
                        <div data-i18n="{{$subMenu->name}}">{{$subMenu->name}}</div>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
        @endempty
        @endforeach
        <!-- <li class="menu-item">
            <a href="tables-basic.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-table"></i>
                <div data-i18n="Tables">Tables</div>
            </a>
        </li>
        <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-layout-grid"></i>
                <div data-i18n="Datatables">Datatables</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item active">
                    <a href="tables-datatables-basic.html" class="menu-link">
                        <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="tables-datatables-advanced.html" class="menu-link">
                        <div data-i18n="Advanced">Advanced</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="tables-datatables-extensions.html" class="menu-link">
                        <div data-i18n="Extensions">Extensions</div>
                    </a>
                </li>
            </ul>
        </li> -->
    </ul>
</aside>