<div class="nav-align-top">
    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
        <!-- <li class="nav-item">
            <a class="nav-link active" data-tab="akademik" onclick="onShowTab(this);" href="javascript:void(0)"><i class="ti-sm ti ti-users me-1_5"></i>Akademik</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" data-tab="alamat" onclick="onShowTab(this);" href="javascript:void(0)"><i class="ti ti-map-pin ti-sm me-1_5"></i>Alamat</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" data-tab="account" onclick="onShowTab(this);" href="javascript:void(0)"><i class="ti-sm ti ti-users me-1_5"></i>Info Tambahan</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" data-tab="security" onclick="onShowTab(this);" href="javascript:void(0)"><i class="ti ti-lock ti-sm me-1_5"></i>Security</a>
        </li>
    </ul>
</div>

<div id="page-akademik" style="display: none;">
    @include('pkl::profile.guru.tab.akademik')
</div>
<div id="page-account" style="display: none;">
    @include('pkl::profile.guru.tab.account')
</div>
<div id="page-alamat" style="display: none;">
    @include('pkl::profile.guru.tab.alamat')
</div>
<div id="page-security" style="display: none;">
    @include('pkl::profile.guru.tab.password')
</div>