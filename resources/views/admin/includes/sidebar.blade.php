<div class="" id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('home') }}"> <img src="{{ Auth::user()->company->logo_horizon_url }}" srcset="" alt="Logo" style="width: 100%; height: auto;"></a>
                </div>
                <div class="toggler">
                    <a class="sidebar-hide d-xl-none d-block" href="#"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="search-container">
                <input class="form-control form-control-lg form-control-plaintext border-bottom search-input ms-3" id="navbar-select" type="text" placeholder="Tìm kiếm chức năng">
            </div>
            <div class="search-item">
                <ul class="menu search-list">
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CREATE_ORDER)) && Auth::user()->company->has_shop)
                        <li class="sidebar-item {{ Request::path() == "quantri/order/pos" ? 'active' : ''}}" data-keyword="Bán Hàng">
                            <a class='sidebar-link' href="{{ route('admin.order', ['key' => 'pos']) }}"> <i class="bi bi-display"></i>
                                <span>Bán Hàng</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Quản lý chung</li>
                    <li class="sidebar-item" data-keyword="Bảng tin">
                        <a class='sidebar-link' href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-fill"></i>
                            <span>Bảng tin</span>
                        </a>
                    </li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ORDERS)))
                    <li class="sidebar-item" data-keyword="Đơn hàng bán hàng">
                        <a class='sidebar-link' href="{{ route('admin.order')}}">
                            <i class="bi bi-receipt-cutoff"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                    @endif
                    {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_TRANSACTIONS)) && Auth::user()->company->has_shop) --}}
                    <li class="sidebar-item" data-keyword="Thanh toán">
                        <a class='sidebar-link' href="{{ route('admin.transaction') }}">
                            <i class="bi bi-coin"></i>
                            <span>Thanh toán</span>
                        </a>
                    </li>
                    {{-- @endif --}}
                    {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_USERS))) --}}
                    <li class="sidebar-item" data-keyword="Tài khoản">
                        <a class='sidebar-link' href="{{ route('admin.user') }}">
                            <i class="bi bi-people-fill"></i>
                            <span>Tài khoản</span>
                        </a>
                    </li>
                    <li class="sidebar-item" data-keyword="Khách hàng">
                        <a class='sidebar-link' href="{{ route('admin.customer') }}">
                            <i class="bi bi-people"></i>
                            <span>Khách hàng</span>
                        </a>
                    </li>
                    {{-- @endif --}}
                    {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)) && Auth::user()->company->has_shop) --}}
                    <li class="sidebar-item has-sub" data-keyword="Sản phẩm">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-stack"></i>
                            <span>Sản phẩm</span>
                        </a>
                        <ul class="submenu">
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS))) --}}
                            <li class="submenu-item" data-keyword="Các sản phẩm">
                                <a href="{{ route('admin.product') }}"> Các sản phẩm</a>
                            </li>
                            {{-- @endif --}}
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATALOGUES))) --}}
                            <li class="submenu-item" data-keyword="Danh mục">
                                <a href="{{ route('admin.catalogue') }}"> Danh mục</a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub" data-keyword="Khu vực">
                        <a class='sidebar-link' href="#"><i class="bi bi-door-closed"></i>
                            <span>Khu vực</span>
                        </a>
                        <ul class="submenu">
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS))) --}}
                            <li class="submenu-item" data-keyword="Quản lý bàn">
                                <a href="{{ route('admin.table') }}"> Quản lý bàn</a>
                            </li>
                            {{-- @endif --}}
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATALOGUES))) --}}
                            <li class="submenu-item" data-keyword="Quản lý phòng">
                                <a href="{{ route('admin.room') }}"> Quản lý phòng</a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </li>
                    {{-- @endif --}}
                    {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CALENDAR_WORK, app\Models\User::READ_WORKS)) && Auth::user()->company->has_attendance) --}}
                    <li class="sidebar-item has-sub" data-keyword="Lịch làm việc">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-calendar3"></i>
                            <span>Lịch làm việc</span>
                        </a>
                        <ul class="submenu">
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CALENDAR_WORK))) --}}
                            <li class="submenu-item" data-keyword="Xếp lịch">
                                <a href="{{ route('admin.schedule')}}"> Xếp lịch</a>
                            </li>
                            {{-- @endif --}}
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WORKS))) --}}
                            <li class="submenu-item" data-keyword="Danh sách chấm công">
                                <a class="text-nowrap" href="{{ route('admin.work.management') }}"> Danh sách chấm công</a>
                            </li>
                            <li class="submenu-item" data-keyword="Thông kê giờ công">
                                <a href="{{ route('admin.work') }}"> Thông kê giờ công</a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </li>
                    {{-- @endif --}}
                    {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMAGES))) --}}
                    <li class="sidebar-item" data-keyword="Thư viện ảnh">
                        <a class='sidebar-link' href="{{ route('admin.image') }}">
                            <i class="bi bi-images"></i>
                            <span>Thư viện ảnh</span>
                        </a>
                    </li>
                    {{-- @endif --}}
                    <li class="sidebar-title">Thiết lập</li>
                    <li class="sidebar-item has-sub" data-keyword="Thiết lập hệ thống">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-sliders"></i>
                            <span>Thiết lập hệ thống</span>
                        </a>
                        <ul class="submenu">
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BRANCHES)) && Auth::user()->company->has_shop) --}}
                            {{-- <li class="submenu-item" data-keyword="Chi nhánh">
                                <a href="{{ route('admin.branch') }}"> Chi nhánh</a>
                            </li> --}}
                            {{-- @endif --}}
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ROLES)))
                            <li class="submenu-item" data-keyword="Phân quyền">
                                <a href="{{ route('admin.role') }}"> Phân quyền</a>
                            </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_COMPANIES)))
                            <li class="submenu-item" data-keyword="Công ty">
                                <a href="{{ route('admin.company') }}"> Công ty</a>
                            </li>
                            @endif
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SETTINGS))) --}}
                            <li class="submenu-item" data-keyword="Cài đặt hệ thống">
                                <a href="{{ route('admin.setting', ['key' => 'general']) }}">Cài đặt hệ thống</a>
                            </li>
                            {{-- @endif --}}
                            {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOGS))) --}}
                            <li class="submenu-item" data-keyword="Nhật ký hệ thống">
                                <a href="{{ route('admin.log') }}"> Nhật ký hệ thống</a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
