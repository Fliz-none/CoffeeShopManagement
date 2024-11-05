<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Đặt món - {{ config('app.name', 'Store Butler') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link href="{{ asset('admin/pos/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    {{-- Toastify --}}
    <link href="{{ asset('admin/pos/vendors/toastify/toastify.css') }}" rel="stylesheet">
    <script src="{{ asset('admin/pos/vendors/toastify/toastify.js') }}"></script>
    {{-- sweet Alert 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
    {{-- input mask js --}}
    <script src="{{ asset('admin/pos/vendors/jquery-mask/jquery.mask.js') }}"></script>
    {{-- swiper slider --}}
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <link href="{{ asset('admin/pos/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/key.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/work.css') }}" rel="stylesheet">
    <script src="{{ asset('admin/pos/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    {{-- <link rel="stylesheet" href="{{ asset('admin/pos/vendors/perfect-scrollbar/perfect-scrollbar.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('admin/pos/vendors/bootstrap-icons/bootstrap-icons.css') }}"> --}}
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link type="image/x-icon" href="{{ Auth::user()->company->favicon_url ?? asset('admin/images/logo/favicon.jpg') }}" rel="shortcut icon">
</head>

<body>
    <div id="app">
        @include('admin.includes.sidebar')
        <div class='layout-navbar' id="main">
            <header class='mb-3'>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid px-0">
                        <a class="burger-btn d-block" href="#">
                            {{-- <i class="bi bi-justify fs-3"></i> --}}
                            <div id="menuToggle">
                                <input type="checkbox" />
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <a class="col-md-2 align-items-center ms-3 mb-2 mb-md-0 text-decoration-none d-md-none d-lg-flex" href="{{ route('admin.dashboard') }}">
                                <img class="inline-logo d-none d-lg-block" src="{{ Auth::user()->company->logo_horizon_url }}" srcset="" alt="Logo">
                            </a>
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link active dropdown-toggle mt-2" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                        <i class='bi bi-bell fs-4 text-gray-600'></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Các thông báo</h6>
                                        </li>
                                        <li><a class="dropdown-item">Chưa có thông báo mới</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="dropdown">
                                <a data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3 d-none d-lg-block">
                                            <h6 class="mb-0 text-primary">{{ Auth::user()->name }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->getRoleNames()->first() }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                @if (Auth::user()->getRoleNames()->first() === 'Super Admin')
                                                    <img src="{{ asset('admin/pos/images/faces/admin.png') }}">
                                                @elseif(Auth::user()->getRoleNames()->first() === 'Chủ quán')
                                                    <img src="{{ asset('admin/pos/images/faces/boss.png') }}">
                                                @else
                                                    <img src="{{ asset('admin/pos/images/faces/user.png') }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Xin chào, {{ Auth::user()->name }}!</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item cursor-pointer btn-profile" data-id="{{ Auth::user()->id }}">
                                            <i class="icon-mid bi bi-person me-2"></i>
                                            Thông tin tài khoản</a>
                                    </li>
                                    <li><a class="dropdown-item cursor-pointer btn-profile-password" data-id="{{ Auth::user()->id }}">
                                            <i class="icon-mid bi bi-key me-2"></i>
                                            Đổi mật khẩu</a>
                                    </li>
                                    <li>
                                    <li><a class="dropdown-item cursor-pointer" href="{{ route('work.attendance') }}">
                                            <i class="bi bi-check2-square me-2"></i>
                                            Chấm công</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i>Logout</a>
                                    </li>
                                    <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content p-1 vh-100">
                <div class="container-fluid overflow-hidden tables">
                    <div class="row mb-4 pt-1 overflow-auto">
                        <div class="col-12 d-flex justify-content-start" style="min-width: 75rem">
                            <button class="btn btn-primary me-1 btn-table-delivery">Bán mang đi</button>
                            <button class="btn btn-primary me-3 btn-booking-room">Đặt phòng</button>
                            <div class="btn-group">
                                <input class="btn-check" id="table-status-all" name="status" type="radio" value="all" checked>
                                <label class="btn btn-outline-primary table-status" for="table-status-all">Tất cả</label>

                                <input class="btn-check" id="table-status-0" name="status" type="radio" value="0">
                                <label class="btn btn-outline-primary table-status" for="table-status-0">Đang trống</label>

                                <input class="btn-check" id="table-status-1" name="status" type="radio" value="1">
                                <label class="btn btn-outline-primary table-status" for="table-status-1">Có khách</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Slider main container -->
                            <div class="tables-swiper">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper py-2">
                                    <!-- Slides -->
                                    @foreach (json_decode(cache()->get('tables')) as $table)
                                        <div class="swiper-slide table-slide">
                                            <label for="table-select-{{ $table->id }}">
                                                <input class="d-none table-select" id="table-select-{{ $table->id }}" name="table" data-status="{{ $table->status }}" data-sort="{{ true }}" type="radio"
                                                    value="{{ $table->id }}">
                                                <div class="card table-card rounded-4 rounded-lg-5 {{ $table->status ? 'table-busy' : 'table-free' }}" data-id="{{ $table->id }}">
                                                    <span class="text-overlay">{{ true }}</span>
                                                    <div class="card-body">
                                                        <h5 class="card-title text-uppercase">{{ $table->name }}</h5>
                                                        <small>{!! $table->status !!}</small>
                                                    </div>
                                                </div>
                                                <div class="table-count {{ $table->count ? '' : 'd-none' }}" data-id="{{ $table->id }}">
                                                    <button class="btn btn-success btn-lg rounded-pill" type="button">{{ $table->count }}</button>
                                                </div>
                                            </label>
                                            <div class="dropstart table-menu" data-id="{{ $table->id }}">
                                                <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu p-2">
                                                    <li>
                                                        <a class="cursor-pointer dropdown-item btn-update-table" data-id="{{ $table->id }}">
                                                            <small><i class="bi bi-pencil-square"></i> Sửa bàn</small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <form class="save-form form-remove-table" action="{{ route('admin.table.remove') }}" method="post">
                                                            @csrf
                                                            <input name="choices[]" type="hidden" value="{{ $table->id }}">
                                                            <button class="cursor-pointer text-danger dropdown-item btn-remove" type="submit">
                                                                <small><i class="bi bi-trash3"></i> Xóa bàn</small>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid products">
                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-start">
                            <div class="btn-group">
                                <input class="btn-check" id="product-catalogue-all" name="catalogue" type="radio" value="all" checked>
                                <label class="btn btn-outline-primary product-catalogue" for="product-catalogue-all">Tất cả</label>
                                @foreach (json_decode(cache()->get('catalogues')) as $catalogue)
                                    <input class="btn-check" id="product-catalogue-{{ $catalogue->id }}" name="catalogue" type="radio" value="{{ $catalogue->id }}">
                                    <label class="btn btn-outline-primary product-catalogue" for="product-catalogue-{{ $catalogue->id }}">{{ $catalogue->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach (json_decode(cache()->get('products')) as $product)
                            <div class="col-6 col-md-3 col-lg-2 product-col">
                                <!-- Card-->
                                <div class="card product-card bg-transparent cursor-pointer" data-id="{{ $product->id }}" data-count="{{ count($product->details) }}">
                                    <div class="ratio ratio-16x9 mb-2">
                                        <img class="card-img-top rounded-4 rounded-lg-5 object-fit-cover" src="{{ $product->avatarUrl }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="row px-3">
                                        <div class="col-10 p-0">
                                            <p class="text-primary card-title mb-0 fw-bold">{{ $product->name }}</p>
                                            <ul class="card-text ps-0 d-flex text-secondary">
                                                <li><small><i class="bi bi-heart-fill"></i> {{ count($product->details) }}</small></li>
                                                <li><small><i class="bi bi-bookmarks-fill"></i> {{ collect($product->catalogues)->pluck('name')->implode(', ') }}</small></li>
                                            </ul>
                                        </div>
                                        <div class="col-2 p-0">
                                            <div class="ratio ratio-1x1 text-center mt-1">
                                                <span class="text-primary border-primary rounded-3 bg-light-primary align-middle fw-bold fs-5 pt-2">{{ number_format($product->price / 1000) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropstart btn-group product-menu" data-id="{{ $product->id }}">
                                        <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu p-2">
                                            <li>
                                                <a class="cursor-pointer dropdown-item btn-update-product" data-id="{{ $product->id }}">
                                                    <small><i class="bi bi-pencil-square"></i> Sửa món</small>
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form class="save-form" action="{{ route('admin.product.remove') }}" method="post">
                                                    @csrf
                                                    <input name="choices[]" type="hidden" value="{{ $product->id }}">
                                                    <button class="cursor-pointer text-danger dropdown-item btn-remove" type="submit">
                                                        <small><i class="bi bi-trash3"></i> Xóa món</small>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="bill-canvas" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="bill-canvas-label" tabindex="-1">
            <div class="offcanvas-header">
                <button class="btn-close" data-bs-dismiss="offcanvas" type="button" aria-label="Close"></button>
                <h5 class="offcanvas-title" id="bill-canvas-label">Chi tiết hóa đơn</h5>
            </div>
            <div class="offcanvas-body pt-0">
                <div class="d-flex justify-content-end align-items-center mb-3 p-1 w-100">
                    <div class="dropdown ajax-search w-100">
                        <div class="form-group mb-0 has-icon-left">
                            <div class="position-relative search-form">
                                <input class="form-control search-input" id="order-search-input" data-url="{{ route('admin.customer') }}?key=search" type="text" autocomplete="off" placeholder="Tìm kiếm khách hàng (F3)">
                                <div class="form-control-icon">
                                    <i class="bi bi-search"></i>
                                </div>
                            </div>
                        </div>
                        <ul class="dropdown-menu shadow-lg overflow-auto w-100 search-result" id="order-search-result" aria-labelledby="dropdownMenuButton" style="max-height: 45rem">
                            <!-- Search results will be appended here -->
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="fs-4 text-secondary d-inline mb-1 align-middle bill-tables"></p>
                    <p class="fs-4 text-secondary d-inline mb-1 align-middle"><span class="badge bg-light-primary text-primary border border-primary bill-created_at"></span></p>
                </div>
                <div class="row bill-controls">
                    <div class="col-6 d-flex align-items-center">
                        <small class="text-secondary bill-meta" style="line-height: 1.2rem"></small>
                    </div>
                    <div class="col-6">
                        <div class="row text-center">
                            <div class="col-4 px-0">
                                <label class="btn btn-outline-primary btn-bill-control btn-bill-split d-none" data-bs-toggle="tooltip" data-bs-title="Tách bill" for="chck-bill-split">
                                    <input class="btn-check chck-bill-split" id="chck-bill-split" type="checkbox" autocomplete="off">
                                    <i class="bi bi-layout-wtf"></i>
                                </label>
                            </div>
                            <div class="col-4 px-0">
                                <label class="btn btn-outline-primary btn-bill-control btn-bill-join d-none" data-bs-toggle="tooltip" data-bs-title="Gộp bill" for="chck-bill-join">
                                    <input class="btn-check chck-bill-join" id="chck-bill-join" type="checkbox" autocomplete="off">
                                    <i class="bi bi-columns"></i>
                                </label>
                            </div>
                            {{-- <div class="col-4 px-0">
                                <button class="btn btn-outline-primary btn-bill-control btn-print" data-bs-toggle="tooltip" data-bs-title="In bill">
                                    <i class="bi bi-printer"></i>
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <hr class="px-4">
                <ul class="bill-details">
                </ul>
                <hr class="px-4">
                <ul class="bill-fees">
                </ul>
                <ul class="bill-discounts">
                </ul>
                <ul class="bill-total">
                </ul>
                <div class="bill-footer d-grid gap-2">
                    <div class="btn-group" role="group">
                        <button class="btn btn-lg btn-success btn-order text-uppercase">
                            <i class="bi bi-receipt"></i>
                            Save và lên bill
                        </button>
                        <button class="btn btn-lg btn-success btn-pay text-uppercase" type="button">
                            <i class="bi bi-coin"></i>
                            Thanh toán bill
                        </button>
                        <button class="btn btn-lg btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                            <span class="visually-hidden">Các chức năng</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item btn-bill-control btn-bill-fee">
                                    Phụ thu
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item btn-bill-control btn-bill-discount">
                                    Giảm giá
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button class="btn btn-outline-primary dropdown-item btn-bill-control btn-bill-cancel">
                                    Hủy bill
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-lg btn-primary d-none btn-bill-split">
                            <i class="bi bi-layout-wtf"></i>
                            Tách bill
                        </button>
                        <button class="btn btn-lg btn-primary d-none btn-bill-join">
                            <i class="bi bi-grid-1x2-fill"></i>
                            Gộp bill
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.includes.footer')
    @include('admin.includes.partials.modal_role')
    @include('admin.includes.partials.modal_user')
    @include('admin.includes.partials.modal_image')
    @include('admin.includes.partials.modal_sort')
    @include('admin.includes.partials.modal_room')
    @include('admin.includes.partials.modal_table')
    @include('admin.includes.partials.modal_booking_room')
    @include('admin.includes.partials.modal_catalogue')
    @if (Request::path() != 'quantri/image')
        <div class="modal fade" id="quick_images-modal" aria-labelledby="quick_images-label" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    @include('admin.includes.quick_images')
                </div>
            </div>
        </div>
    @endif
    <div class="loading">
        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;"></div>
        <span class="badge bg-light-primary mt-3">Đang tải</span>
    </div>
    <div class="paybooking-form">
    </div>
</body>

<script>
    let general = {
        routes: {
            table: {
                get: `{{ route('admin.table') }}`,
                create: `{{ route('admin.table.create') }}`,
                update: `{{ route('admin.table.update') }}`,
                remove: `{{ route('admin.table.remove') }}`,
            },
            product: {
                get: `{{ route('admin.product') }}`,
                create: `{{ route('admin.product.create') }}`,
                update: `{{ route('admin.product.update') }}`,
                remove: `{{ route('admin.product.remove') }}`,
            },
            order: {
                get: `{{ route('admin.order') }}`,
                create: `{{ route('admin.order.create') }}`,
                update: `{{ route('admin.order.update') }}`,
                remove: `{{ route('admin.order.remove') }}`,
                sync: `{{ route('admin.order.sync') }}`,
                pay: `{{ route('admin.order.pay') }}`,
            },
            transaction: {
                get: `{{ route('admin.transaction') }}`,
                create: `{{ route('admin.transaction.create') }}`,
                update: `{{ route('admin.transaction.update') }}`,
                remove: `{{ route('admin.transaction.remove') }}`,
            },
        },
    };
</script>
<script src="{{ asset('admin/pos/js/main.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        });

        /**
         * Khai báo biến toàn cục
         */
        if (!localStorage.bills) localStorage.bills = '[]'

        reloadTables().done(function() {
            $('.loading').addClass('d-none')
        })
        swiperTables()

        /**
         * Xử lý tìm kiếm
         */
        function debounce(func, delay) {
            let timeoutId;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    func.apply(context, args);
                }, delay);
            };
        }

        const debouncedSearch = debounce(handleSearch, 200);

        $('.search-form input').on('input', debouncedSearch);

        function handleSearch() {
            const searchTerm = $('.search-form input').val(),
                input = $('.search-form input');
            if (input.val() != '') {
                {{--  // $.get(`{{ route('main.search') }}/${searchTerm}`, function(response) {
                //     prouctIds = response[0].map(product => product.id)
                //     showProducts(prouctIds)
                //     tableIds = response[1].map(table => table.id)
                //     showTables(tableIds)
                // }) --}}
            } else {
                input.parents('.dropdown').dropdown('hide')
            }
        }

        $(document).keydown(function(e) {
            if (event.key === 'Escape') {
                $('.search-form input').val('').change().focus().parents('.dropdown').dropdown('hide');
                showProducts('all')
                showTables('all');
            }
        })

        /**
         * Save form
         */
        $('.save-form').submit(function(e) {
            e.preventDefault();
            const form = $(this)
            submitForm(form).done(function(data) {
                reloadProducts()
                reloadTables()
                loadRooms();
            })
        })

        /**
         * Xử lý hiển thị product
         */
        $('.product-catalogue').click(function() {
            const id = $(this).prev().val()
            if (id == 'all') {
                showProducts('all')
            } else {
                const products = {!! Cache::get('products') !!};
                productFiltered = Object.values(products).filter(item => item.catalogues[0].id == id),
                    ids = productFiltered.map(product => product.id);
                showProducts(ids)
            }
        })

        function showProducts(ids) {
            $('.product-col').removeClass('d-none')
            if (typeof ids == 'object') {
                $('.product-card').each(function() {
                    if (!ids.includes(parseInt($(this).attr('data-id')))) {
                        $(this).parents('.product-col').addClass('d-none')
                    }
                })
            }
        }

        $(document).on('click', '.table-menu', function(e) {
            e.stopPropagation()
        })

        function reloadProducts() {
            let products = {!! Cache::get('products') !!},
                currents = products
            return $.get(general.routes.product.get + '/all', function(newProducts) {
                localStorage.products = JSON.stringify(newProducts)
                products = newProducts
                let ids = products.map(product => product.id)
                $('.product-card').each(function() {
                    if (!ids.includes(parseInt($(this).attr('data-id')))) {
                        $(this).parents('.product-col').remove()
                    }
                })
                products.forEach(product => {
                    let current = false
                    $.each(currents, function(item) {
                        if (item.id == product.id) {
                            current = item
                            return false
                        };
                    })
                    if (current) {
                        if (JSON.stringify(product) !== JSON.stringify(current)) {
                            reloadProduct(product)
                        }
                    }
                });
            })
        }

        function reloadProduct(product) {
            const str = `
                    <!-- Card-->
                    <div class="card product-card bg-transparent cursor-pointer" data-id="${product.id}" data-count="${product.count}">
                        <div class="ratio ratio-16x9 mb-2">
                            <img src="${product.thumb}" class="card-img-top rounded-4 rounded-lg-5 object-fit-cover" alt="${product.name}">
                        </div>
                        <div class="row px-3">
                            <div class="col-10 p-0">
                                <p class="text-primary card-title mb-0 fw-bold">${product.name}</p>
                                <ul class="card-text ps-0 d-flex text-secondary">
                                    <li><small><i class="bi bi-heart-fill"></i> ${product.count}</small></li>
                                    <li><small><i class="bi bi-bookmarks-fill"></i> ${product.catalogue.name}</small></li>
                                </ul>
                            </div>
                            <div class="col-2 p-0">
                                <div class="ratio ratio-1x1 text-center mt-1">
                                    <span class="text-primary border-primary rounded-3 bg-light-primary align-middle fw-bold fs-5 pt-2">${number_format(product.price/1000)}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropstart btn-group product-menu" data-id="${product.id}">
                            <button class="btn btn-link mb-0 px-2 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu p-2">
                                <li>
                                    <a class="cursor-pointer dropdown-item btn-update-product" data-id="${product.id}">
                                        <small><i class="bi bi-pencil-square"></i> Sửa món</small>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <form action="${general.routes.product.remove}" method="post" class="save-form">
                                        @csrf
                                        <input type="hidden" name="choices[]" value="${product.id}">
                                        <button type="submit" class="cursor-pointer text-danger dropdown-item btn-remove">
                                            <small><i class="bi bi-trash3"></i> Xóa món</small>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>`
            if ($(`.product-card[data-id=${product.id}]`).length) {
                $(`.product-card[data-id=${product.id}]`).parents('.product-col').html(str)
            } else {
                $(`.product-card`).each(function() {
                    if ($(this).attr('data-count') > product.count) {
                        $(this).parents('.product-col').before($(`<div class="col-6 col-md-3 col-lg-2 product-col">${str}</div>`))
                        return false
                    }
                })
            }
        }

        /**
         * Xử lý hiển thị danh sách bàn
         */
        $('.table-status').add('.table-area').click(function() {
            let tables = {!! Cache::get('tables') !!};
            setTimeout(() => {
                const status = $('.tables').find('[name=status]:checked').val()
                const area = $('.tables').find('[name=area]:checked').val()
                const tableFiltered = tables.filter(item => (status == 'all' ? 1 : item.status == status) && (area == 'all' ? 1 : item.area == area));
                const ids = tableFiltered.map(table => table.id)
                showTables(ids)
            }, 100);
        })

        function showTables(ids) {
            $('.table-slide').removeClass('d-none')
            if (typeof ids == 'object') {
                $('.table-select').each(function() {
                    if (!ids.includes(parseInt($(this).val()))) {
                        $(this).parents('.table-slide').addClass('d-none')
                    }
                })
            }
            swiperTables()
        }

        $(document).on('click', '.product-menu', function(e) {
            e.stopPropagation()
        })

        function swiperTables() {
            const swiper = new Swiper('.tables-swiper', {
                freeMode: true,
                loop: true,
                spaceBetween: 15,
                breakpoints: {
                    375: {
                        slidesPerView: 3,
                    },
                    640: {
                        slidesPerView: 4,
                    },
                    768: {
                        slidesPerView: 6,
                    },
                    1024: {
                        slidesPerView: 8,
                    },
                    1920: {
                        slidesPerView: 10,
                    },
                },
            });
        }

        function displayTables() {
            // Lấy danh sách bàn mới từ server thay vì từ cache
            $.get(`{{ route('admin.table', ['key' => 'list']) }}`, function(tables) {
                let bills = JSON.parse($("<textarea/>").html(localStorage.bills).text());

                // Duyệt qua từng table để cập nhật count
                tables.forEach(table => {
                    table.count = table.status ? table.count : 0;

                    // Tính toán số lượng món order trên mỗi bàn
                    $.each(bills, function(index, bill) {
                        let tableIds = bill.tables.map(table => table.id),
                            quantities = bill.details.map(detail => detail.quantity);

                        if (tableIds.includes(table.id)) {
                            table.count = quantities.reduce((acc, current) => acc + current, 0);
                        }
                    });

                    // Cập nhật lại giao diện cho từng bàn
                    reloadTable(table);
                });
            });
        }


        function isValidJSON(text) {
            try {
                JSON.parse(text);
                return true;
            } catch (error) {
                return false;
            }
        }

        function reloadTables(ids = null) {
            var tables = {!! Cache::get('tables') !!},
                bills;
            if (isValidJSON(localStorage.bills)) {
                bills = JSON.parse($("<textarea/>").html(localStorage.bills).text());
            } else {
                bills = [];
            }

            var currents = tables;

            return $.get(`{{ route('admin.table', ['key' => 'list']) }}`, function(newTables) {
                tables = newTables;
                let ids = tables.map(table => table.id);
                $('.table-select').each(function() {
                    if (!ids.includes(parseInt($(this).val()))) {
                        $(this).parents('.table-slide').remove();
                    }
                });
                displayTables();
            });
        }


        function reloadTable(table) {
            //Nếu có bàn đó rồi thì cập nhật bàn
            if ($(`.table-select[value=${table.id}]`).length) {
                $(`label[for=table-select-${table.id}]`).find('.table-card').remove()
                $(`label[for=table-select-${table.id}]`).find('.table-count').remove()
                $(`label[for=table-select-${table.id}]`).append(`
                    <div class="card table-card rounded-4 rounded-lg-5 ${table.status ? 'table-busy' : 'table-free' }" data-id="${table.id}">
                        <span class="text-overlay">${ table.id }</span>
                        <div class="card-body">
                            <h5 class="card-title text-uppercase">${ table.name }</h5>
                            <small>${ table.statusStr }</small>
                            <small class="fw-bold">${ table.note ? table.note : '' }</small>
                        </div>
                    </div>
                    <div class="table-count ${ table.count != 0 ? '' : 'd-none' }" data-id="${table.id}">
                        <button type="button" class="btn btn-success btn-lg rounded-pill">${ table.count }</button>
                    </div>`)
            } else { //Nếu chưa thì tìm bàn có thứ tự sắp xếp lớn hơn rồi chen bàn mới vô
                const str = `
                <label for="table-select-${table.id}">
                    <input type="radio" name="table" id="table-select-${table.id}" value="${table.id}" data-status="${(table.status) ? 1 : 0}" data-sort="${table.sort}" class="d-none table-select">
                    <div class="card table-card rounded-4 rounded-lg-5 ${ table.status ? 'table-busy' : 'table-free' }" data-id="${table.id}">
                        <span class="text-overlay">${ table.id }</span>
                        <div class="card-body">
                            <h5 class="card-title text-uppercase">${ table.name }</h5>
                            <small>${ table.statusStr }</small>
                        </div>
                    </div>
                    <div class="table-count ${ table.count != 0 ? '' : 'd-none' }" data-id="${table.id}">
                        <button type="button" class="btn btn-success btn-lg rounded-pill">${ table.count }</button>
                    </div>
                </label>
                <div class="dropstart table-menu" data-id="${table.id}">
                    <button class="btn btn-link mb-0 px-2 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li>
                            <a class="cursor-pointer dropdown-item btn-update-table" data-id="${table.id}">
                                <small><i class="bi bi-pencil-square"></i> Sửa bàn</small>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <form action="${ general.routes.table.remove }" method="post" class="form-remove-table save-form">
                                @csrf
                                <input type="hidden" name="choices[]" value="${table.id}">
                                <button type="submit" class="cursor-pointer text-danger dropdown-item btn-remove">
                                    <small><i class="bi bi-trash3"></i> Xóa bàn</small>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>`
                $(`.table-select`).each(function() {
                    if ($(this).attr('data-sort') > table.sort) {
                        $(this).parents('.table-slide').before($(`<div class="swiper-slide table-slide">${str}</div>`))
                        return false
                    }
                })
            }
        }

        /**
         * Xử lý hiển thị các nút chức năng của bill
         */
        $(document).on('click', '.bill-control', function() {
            $(this).parents('.bill-controls').find('.bill-control').toggleClass('d-none')
        })

        $(document).on('click', '.btn-bill-control', function(e) {
            e.stopPropagation()
        })

        $(document).on('change', '.btn-check', function() {
            $(this).parents(`[for='${$(this).attr('id')}']`).toggleClass('checked')
            if ($('.chck-bill-split').is(':checked') || $('.chck-bill-join').is(':checked')) {
                $('.bill-footer .btn-group:first-child').addClass("d-none")
            } else {
                $('.bill-footer .btn-group:first-child').removeClass("d-none")
            }
            if ($(this).hasClass('chck-bill-split')) {
                $('.bill-footer .btn-bill-split').toggleClass("d-none", !this.checked)
            }
            if ($(this).hasClass('chck-bill-join')) {
                $('.bill-footer .btn-bill-join').toggleClass("d-none", !this.checked)
            }
        }).change();

        $(document).on('click', '.btn-bill-discount', function() {
            createAddition('discount')
        })

        $(document).on('click', '.btn-bill-fee', function() {
            createAddition('fee')
        })

        function createAddition(type) {
            const bill = pickBill(),
                str = (type == 'fee') ? {
                    warningSwal: 'Phải thêm ít nhất một món trước khi tính phụ phí?',
                    title: 'Phụ thu bill',
                    noteInput: 'Nội dung thu',
                    amountInput: 'Số tiền thu',
                    type: 1,
                    value: 'Phụ thu'
                } : {
                    warningSwal: 'Phải thêm ít nhất một món trước khi giảm giá?',
                    title: 'Giảm giá bill',
                    noteInput: 'Nội dung giảm',
                    amountInput: 'Số tiền giảm',
                    type: 0,
                    value: 'Giảm giá'
                }
            if (!bill.details.length) {
                Swal.fire({
                    title: "Lưu ý!",
                    text: str.warningSwal,
                    icon: "warning"
                });
            } else {
                let additionNote, additionAmount;
                Swal.fire({
                    title: str.title,
                    html: `
                <input type="text" id="bill-addition-note" class="form-control mb-2" value="${str.value}" placeholder="${str.noteInput}">
                <input type="text" id="bill-addition-amount" class="form-control money" placeholder="${str.amountInput}" inputmode="numeric">`,
                    confirmButtonText: 'Thêm',
                    focusConfirm: false,
                    didOpen: () => {
                        additionNote = Swal.getPopup().querySelector('#bill-addition-note');
                        additionAmount = Swal.getPopup().querySelector('#bill-addition-amount');
                        additionAmount.addEventListener('input', function() {
                            $(this).val($(this).val().replace(/[^0-9]/g, ''));
                        });
                        $('.money').focus(function() {
                            $('.money').mask("# ##0", {
                                reverse: true
                            });
                        });
                        $('.money').blur(function() {
                            $('.money').unmask();
                        })
                        additionNote.addEventListener('keyup', (event) => event.key === 'Enter' && Swal.clickConfirm());
                        additionAmount.addEventListener('keyup', (event) => event.key === 'Enter' && Swal.clickConfirm());
                    },
                    preConfirm: () => {
                        const note = additionNote.value,
                            amount = additionAmount.value
                        //Kiem tra gia don so voi gia giam
                        // Kiểm tra xem cả hai trường đều được nhập và trường số tiền chỉ chứa giá trị số
                        if (!note || !amount || isNaN(parseFloat(amount))) {
                            Swal.showValidationMessage(`Dữ liệu không hợp lệ!`);
                        }
                        // else if (str.type == 0 && !validAddition(amount, bill)) { //////////////////////////
                        //     Swal.showValidationMessage(`Giá giảm không thể lớn hơn giá đơn`);
                        // }
                         else {
                            // Kiểm tra xem có phần tử nào có note như vậy không
                            var isNoteExists = false;
                            $.each(bill.additions, function(index, addition) {
                                if (addition.note === note && addition.type === str.type) {
                                    // Nếu tồn tại, cập nhật giá trị của amount
                                    addition.amount = amount.replace(/[^0-9]/g, '');
                                    isNoteExists = true;
                                    return false; // Dừng vòng lặp khi tìm thấy phần tử
                                }
                            });
                            // Nếu không tìm thấy phần tử với note, thêm phần tử mới
                            if (!isNoteExists) {
                                bill.additions.push({
                                    id: parseInt(Math.random().toString().substr(2, 9)),
                                    order_id: bill.id,
                                    type: str.type,
                                    note: note,
                                    amount: amount.replace(/[^0-9]/g, ''),
                                    status: 0,
                                    deleted_at: null,
                                    created_at: "2024-01-28T19:29:16.000000Z",
                                    updated_at: "2024-02-11T15:23:53.000000Z"
                                });
                            }
                        }
                        updateBill(bill)
                        displayBill(bill)
                        if (bill.status) {
                            syncBill(bill)
                        }
                    },
                });
            }
        }

        $(document).on('click', '.btn-bill-cancel', function() {
            const bill = pickBill(),
                tables = {!! Cache::get('tables') !!};
            if (bill.status) {
                $('.loading').removeClass('d-none')
                $.ajax({
                    data: {
                        choices: [bill.id]
                    },
                    url: general.routes.order.remove,
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('.loading').addClass('d-none')
                        destroyBill(bill.id)
                        Toastify({
                            text: response.msg,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            backgroundColor: `var(--${response.status})`,
                        }).showToast();
                        $('.table-select').prop('checked', false)
                        $('#bill-canvas').offcanvas('hide')
                    },
                    error: function(errors) {
                        $('.loading').addClass('d-none')
                        console.log('Error:', errors);
                        if (errors.status === 422) {
                            Toastify({
                                text: error[0],
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: 'var(--danger)',
                            }).showToast();
                        } else if (errors.status === 419 || errors.status === 401) {
                            console.warn(errors.responseJSON.errors);
                            window.location.href = `{{ route('admin.login') }}`;
                        } else {
                            Swal.fire(
                                'ĐÃ CÓ LỖI XẢY RA!',
                                'Vui lòng liên hệ đơn vị phần mềm để được hỗ trợ!',
                                'error'
                            )
                        }
                    }
                })
            } else {
                destroyBill(bill.id)
                let names = bill.tables.map(table => table.name)
                Toastify({
                    text: 'Đã hủy order nháp ' + names.join(', '),
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: `var(--success)`,
                }).showToast();
                $('.table-select').prop('checked', false)
                $('#bill-canvas').offcanvas('hide')
                return true
            }
            displayTables()
        })

        function destroyBill(id) {
            const bills = JSON.parse(localStorage.bills)
            $.each(bills, function(index, bill) {
                if (bill.id == id) {
                    bills.splice(index, 1)
                    return false
                }
            })
            localStorage.bills = JSON.stringify(bills)
            reloadTables()
        }

        $(document).on('click', '.table-count', function() {
            $(this).parents('label').trigger('click')
            $('#bill-canvas').offcanvas('show')
        })

        $(document).on('change', '.table-select', function() {
            localStorage.removeItem('customer_id');
            const id = $(this).val(),
                status = parseInt($(this).attr('data-status')),
                invertStatus = (status) ? 0 : 1
            $(`.table-select[data-status=${invertStatus}]`).prop('checked', false)
            $('.loading').removeClass('d-none')
            $.get(`{{ route('admin.order', ['key' => 'getByTable']) }}` + '/' + id, function(bill) { //Kiểm tra coi bàn đó có bill nào chưa
                if (bill != 0) { //Rồi thì load lại
                    bill.status = 2
                    bill.featured = 1
                    bill.details.forEach(detail => {
                        detail.status = 1
                    });
                    bill.additions.forEach(addition => {
                        addition.status = 1
                    });
                    blurBills()
                    updateBill(bill)
                    displayBill(bill)
                } else { //Chưa thì tạo bill mới từ các bàn được chọn
                    //Lấy danh sách id của các bàn được chọn
                    let checkedIds = $(".table-select:checked").map(function() {
                            return parseInt($(this).val());
                        }).get(),
                        collectedTables = []
                    //Lọc ra các table có id theo danh sách trên đưa vào bill
                    let tables = {!! Cache::get('tables') !!}
                    tables.forEach(table => {
                        if (checkedIds.includes(table.id)) {
                            collectedTables.push(table)
                        }
                    });
                    let bill = pickBillByTable(id)
                    bill.tables = collectedTables
                    updateBill(bill)
                    displayBill(bill)
                }
                displayTables()
                $('#bill-canvas').offcanvas('show')
                $('.loading').addClass('d-none')
            })
        })

        $('.btn-table-delivery').click(function() {
            $(`.table-select`).prop('checked', false)
            let bill = pickBillByTable('delivery')
            bill.tables.length = 0
            updateBill(bill)
            displayBill(bill)
        })

        function updateBill(bill) {
            let bills = localStorage.bills,
                updated = false,
                totalDetailsArr = bill.details.map(detail => detail.quantity * detail.price),
                sumDetails = totalDetailsArr.reduce((acc, current) => acc + current, 0)
            totalTransactionArr = bill.transactions.map(transaction => transaction.amount),
                sumTransactions = totalTransactionArr.reduce((acc, current) => acc + current, 0)
            //chọn bill để thêm vào
            if (bills !== undefined && JSON.parse(bills).length != 0) {
                bills = JSON.parse(localStorage.bills)
                $.each(bills, function(index, item) {
                    if (item.id == bill.id) {
                        if (sumTransactions >= sumDetails) {
                            bills.splice(index, 1)
                        } else {
                            bills[index] = bill
                        }
                        updated = true
                        return false
                    }
                });
            } else {
                bills = []
            }
            if (!updated) {
                bills.push(bill)
            }
            localStorage.bills = JSON.stringify(bills)
        }

        function pickBillByTable(tableId) {
            blurBills()
            let bills = localStorage.bills,
                bill
            //chọn bill để thêm vào
            if (bills !== undefined && JSON.parse(bills).length != 0) {
                JSON.parse(bills).forEach(item => {
                    let selected = false
                    if (item.tables.length === 0 && tableId === 'delivery') {
                        bill = item
                        bill.featured = 1
                        return false
                    } else {
                        item.tables.forEach(table => {
                            if (table.id == tableId) {
                                bill = item
                                bill.featured = 1
                                selected = true
                            }
                        })
                        if (selected) {
                            return false
                        }
                    }
                });
            }
            if (bill === undefined) {
                bill = definedBill()
            }
            return bill
        }

        function pickBill() {
            let bills = localStorage.bills,
                bill
            //chọn bill để thêm vào
            if (bills !== undefined && JSON.parse(bills).length != 0) { //Nếu đã có danh sách bill
                JSON.parse(bills).forEach(item => {
                    if (item.featured) {
                        bill = item
                        return false
                    }
                });
            }
            if (bill === undefined) {
                bill = definedBill()
            }
            return bill
        }

        function blurBills() {
            let bills = localStorage.bills
            if (bills !== undefined && JSON.parse(bills).length != 0) {
                bills = JSON.parse(bills)
                bills.forEach(item => {
                    item.featured = 0
                })
                localStorage.bills = JSON.stringify(bills)
            }
        }

        function definedBill() {
            return {
                id: parseInt(Math.random().toString().substr(2, 9)),
                user_id: `{{ Auth::user()->id }}`,
                checkout_at: null,
                note: null,
                deleted_at: null,
                created_at: new Date(),
                details: [],
                transactions: [],
                dealer: {!! Cache::get('cashier') !!},
                tables: [],
                additions: [],
                status: 0, //0: draft; 1: edit; 2: saved
                featured: 1
            }
        }

        $(document).on('click', '.product-card', function() {
            const id = $(this).attr('data-id')
            let checkProductExist, detail,
                products = {!! Cache::get('products') !!},
                bill = pickBill()
            //Kiểm tra coi sản phẩm mới click có trong bill chưa
            $.each(bill.details, function(index, detail) {
                if (detail.product.id == id && (detail.note == null || detail.note == '')) {
                    checkProductExist = index;
                    return false;
                }
            });
            if (!bill.details.length) bill.created_at = $.now() //Nếu bill chưa có sản phẩm nào thì reset thời gian bill
            //Nếu chưa thì tìm sản phẩm trong mảng products
            if (checkProductExist === undefined) {
                let product = false
                $.each(products, function(index, item) {
                    if (item.id == id) {
                        product = item
                        return false
                    } else {
                        product = false
                    }
                })
                if (product) {
                    //Đưa vào bill
                    detail = {
                        id: parseInt(Math.random().toString().substr(2, 9)),
                        product_id: product.id,
                        quantity: 1,
                        price: product.price,
                        note: null,
                        product: product,
                        status: 0
                    }
                    bill.details.push(detail)
                } else {
                    Toastify({
                        text: 'Đã có lỗi xảy ra! Hãy thử lại',
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: 'var(--danger)',
                    }).showToast();
                }
            } else { //Nếu rồi thì tăng số lượng lên 1 đơn vị
                bill.details[checkProductExist].quantity += 1
            }
            bill.status = (bill.status) ? 1 : 0
            updateBill(bill)
            displayBill(bill)
            reloadTables()
            if (bill.status) {
                syncBill(bill)
            }
        })

        /**
         * Xử lý các nút chức năng của chi tiết bill
         */
        $(document).on('click', '.bill-detail-control', function() {
            $(this).parents('.bill-detail').find('.bill-detail-control').toggleClass('d-none')
        })

        $(document).on('click', '.btn-detail-remove', function() {
            const id = $(this).attr('data-id'),
                bill = pickBill()
            $.each(bill.details, function(index, detail) {
                if (detail.id == id) {
                    bill.details.splice(index, 1)
                    return false
                }
            });
            bill.status = (bill.status) ? 1 : 0
            updateBill(bill)
            displayBill(bill)
            displayTables()
            if (bill.status) {
                syncBill(bill)
            }
        })

        $(document).on('click', '.btn-detail-price', function() {
            const id = $(this).attr('data-id'),
                bill = pickBill()
            let detailPrice,
                price = ''
            $.each(bill.details, function(index, detail) {
                if (detail.id == id) {
                    price = detail.price
                    return false; // Dừng vòng lặp khi tìm thấy phần tử
                }
            });
            Swal.fire({
                title: 'Sửa giá',
                html: `<input type="text" id="bill-detail-price" value="${price}" class="form-control money" placeholder="Nhập giá mới" inputmode="numeric">`,
                confirmButtonText: 'OK',
                focusConfirm: false,
                didOpen: () => {
                    detailPrice = Swal.getPopup().querySelector('#bill-detail-price');
                    detailPrice.focus()
                    detailPrice.addEventListener('input', function() {
                        $(this).val($(this).val().replace(/[^0-9]/g, ''));
                    });
                    $('.money').focus(function() {
                        $(this).mask("# ##0", {
                            reverse: true
                        });
                    });
                    $('.money').blur(function() {
                        $(this).unmask();
                    })
                    detailPrice.addEventListener('keyup', (event) => event.key === 'Enter' && Swal.clickConfirm());
                },
                preConfirm: () => {
                    const price = detailPrice.value
                    // Kiểm tra xem cả hai trường đều được nhập và trường số tiền chỉ chứa giá trị số
                    if (!price || isNaN(parseFloat(price))) {
                        Swal.showValidationMessage(`Dữ liệu không hợp lệ!`);
                    } else {
                        // Kiểm tra xem có phần tử nào có id như vậy không
                        $.each(bill.details, function(index, detail) {
                            if (detail.id == id) {
                                // Nếu tồn tại, cập nhật giá trị của price
                                detail.price = price.replace(/[^0-9]/g, '');
                                return false; // Dừng vòng lặp khi tìm thấy phần tử
                            }
                        });
                    }
                    bill.status = (bill.status) ? 1 : 0
                    updateBill(bill)
                    displayBill(bill)
                    if (bill.status) {
                        syncBill(bill)
                    }
                },
            });
        })

        $(document).on('click', '.btn-detail-down', function() {
            const id = $(this).attr('data-id'),
                bill = pickBill()
            $.each(bill.details, function(index, detail) {
                if (detail.id == id) {
                    detail.quantity -= 1
                    if (!detail.quantity) {
                        bill.details.splice(index, 1)
                    }
                    return false
                }
            });
            bill.status = (bill.status) ? 1 : 0
            updateBill(bill)
            displayBill(bill)
            displayTables()
            if (bill.status) {
                syncBill(bill)
            }
        })

        $(document).on('click', '.btn-detail-note', function() {
            const id = $(this).attr('data-id'),
                bill = pickBill()
            let detailNote,
                note = ''
            $.each(bill.details, function(index, detail) {
                if (detail.id == id) {
                    // Nếu tồn tại, cập nhật giá trị của note
                    note = detail.note
                    return false; // Dừng vòng lặp khi tìm thấy phần tử
                }
            });
            Swal.fire({
                title: 'Ghi chú món',
                html: `
                <input type="text" id="bill-detail-note" value="${(note) ? note : ''}" class="form-control money" placeholder="Nhập nội dung">`,
                confirmButtonText: 'OK',
                focusConfirm: false,
                didOpen: () => {
                    detailNote = Swal.getPopup().querySelector('#bill-detail-note');
                    detailNote.focus()
                    $('.money').focus(function() {
                        $('.money').mask("# ##0", {
                            reverse: true
                        });
                    });
                    $('.money').blur(function() {
                        $('.money').unmask();
                    })
                    detailNote.addEventListener('keyup', (event) => event.key === 'Enter' && Swal.clickConfirm());
                },
                preConfirm: () => {
                    const note = detailNote.value
                    // Kiểm tra xem có phần tử nào có id như vậy không
                    $.each(bill.details, function(index, detail) {
                        if (detail.id == id) {
                            // Nếu tồn tại, cập nhật giá trị của note
                            detail.note = note;
                            return false; // Dừng vòng lặp khi tìm thấy phần tử
                        }
                    });
                    bill.status = (bill.status) ? 1 : 0
                    updateBill(bill)
                    displayBill(bill)
                    if (bill.status) {
                        syncBill(bill)
                    }
                },
            });
        })

        $(document).on('click', '.btn-detail-split', function() {
            const id = $(this).attr('data-id'),
                bill = pickBill()
            $.each(bill.details, function(index, detail) {
                if (detail.id == id) {
                    if (detail.quantity > 1) {
                        detail.quantity -= 1
                        newDetail = {
                            id: parseInt(Math.random().toString().substr(2, 9)),
                            product_id: detail.product.id,
                            quantity: 1,
                            price: detail.product.price,
                            note: null,
                            product: detail.product,
                            status: 0
                        }
                        bill.details.push(newDetail)
                        bill.status = (bill.status) ? 1 : 0
                        updateBill(bill)
                        displayBill(bill)
                        if (bill.status) {
                            syncBill(bill)
                        }
                    } else {
                        Swal.fire({
                            title: "Lưu ý!",
                            text: "Từ 2 món trở lên mới tách được!",
                            icon: "warning"
                        });
                    }
                    return false
                }
            });
        })

        $(document).on('change', '.detail-select', function() {
            if (!$(this).prop('checked')) {
                $(this).parents('.bill-detail').find('.bill-detail-control').toggleClass('d-none')
            }
        })

        function displayBill(bill) {
            console.log(bill);
            //Hiển thị bàn
            let tableStr = ''
            if (bill.tables.length > 0) {
                tableStr += `Tên bàn ◆ `
                let orderTables = $.map(bill.tables, function(table, index) {
                    return `<span class="badge bg-primary ms-1">${table.name}</span>`;
                });
                tableStr += orderTables.join('')
            } else {
                tableStr += `<span class="badge bg-success"><i class="bi bi-rocket-takeoff"></i></span> Mang đi`
            }
            $('.bill-tables').html(tableStr)
            //Hiển thị giờ tạo
            $('.bill-created_at').html(moment(bill.created_at).format('HH:mm'))
            $('.bill-meta').html(`Số: ${bill.id}<br/>Thu ngân: ${bill.dealer.name}`)
            bill.customer ? $('.bill-meta').append(`<br/>Khách hàng: ${bill.customer.name}`) : ''
            //Hiển thị chi tiết
            let detailStr = ''
            bill.details.forEach(detail => {
                detailStr += `
                    <li class="bill-detail mb-3">
                        <input type="checkbox" value="${detail.id}" id="detail-select-${detail.id}" class="d-none detail-select">
                        <label for="detail-select-${detail.id}" class="w-100">
                            <div class="row justify-content-start ms-0 align-items-center">
                                <div class="col-2 p-0">
                                    <div class="ratio ratio-1x1 detail-thumb">
                                        <img src="${detail.product.avatarUrl}" alt="${detail.product.name}" class="card-img object-fit-cover">
                                    </div>
                                </div>
                                <div class="col-10 bill-detail-control ps-3">
                                    <h6 class="text-primary bill-detail-title mb-0" data-bs-toggle="tooltip" data-bs-title="${detail.product.name}">${detail.product.name}</h6>
                                    <ul class="ps-1">
                                        <li>
                                            <small class="text-dark fw-bold bill-detail-misc">${detail.quantity} &times; ${number_format(detail.price)}đ</small>
                                        </li>
                                        ${(detail.note) ? `<li>
                                            <small class="text-secondary bill-detail-note" data-bs-toggle="tooltip" data-bs-title="${detail.note}">${detail.note}</small>
                                        </li>` : ''}
                                    </ul>
                                </div>
                                <div class="col-2 bill-detail-control d-none p-0">
                                    <button class="btn btn-link btn-lg btn-detail-remove" type="button" data-id="${detail.id}" data-bs-toggle="tooltip" data-bs-title="Xóa món">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="col-2 bill-detail-control d-none p-0">
                                    <button class="btn btn-link btn-lg btn-detail-price" type="button" data-id="${detail.id}" data-bs-toggle="tooltip" data-bs-title="Sửa giá">
                                        <i class="bi bi-coin"></i>
                                    </button>
                                </div>
                                <div class="col-2 bill-detail-control d-none p-0">
                                    <button class="btn btn-link btn-lg btn-detail-down" type="button" data-id="${detail.id}" data-bs-toggle="tooltip" data-bs-title="Giảm số lượng">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </div>
                                <div class="col-2 bill-detail-control d-none p-0">
                                    <button class="btn btn-link btn-lg btn-detail-note" type="button" data-id="${detail.id}" data-bs-toggle="tooltip" data-bs-title="Ghi chú">
                                        <i class="bi bi-chat-fill"></i>
                                    </button>
                                </div>
                                <div class="col-2 bill-detail-control d-none p-0">
                                    <button class="btn btn-link btn-lg btn-detail-split" type="button" data-id="${detail.id}" data-bs-toggle="tooltip" data-bs-title="Tách món">
                                        <i class="bi bi-vr"></i>
                                    </button>
                                </div>
                            </div>
                        </label>
                    </li>`
            });
            $('ul.bill-details').html(detailStr)

            //Hiển thị các phụ phí
            let feeStr = '',
                feeAmount = 0,
                discountStr = '',
                discountAmount = 0,
                totalDetailArr = bill.details.map(detail => detail.price * detail.quantity),
                sumDetails = totalDetailArr.reduce((acc, current) => acc + current, 0),
                totalTransactionArr = bill.transactions.map(transaction => transaction.amount),
                sumTransactions = totalTransactionArr.reduce((acc, current) => acc + current, 0)

            bill.additions.forEach(addition => {
                if (addition.type) {
                    feeAmount += calcSubAmount(sumDetails, addition.amount)
                    feeStr += `
                        <li>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <p class="text-secondary d-inline mb-1 align-middle bill-fee-note">${addition.note}</p>
                                <small class="text-dark d-inline mb-1 align-middle fs-5 bill-fee-amount">+${number_format(calcSubAmount(sumDetails, addition.amount))}</small>
                            </div>
                        </li>`
                } else {
                    discountAmount += calcSubAmount(sumDetails, addition.amount)
                    discountStr += `
                    <li>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <p class="text-secondary d-inline mb-1 align-middle bill-discount-note">${addition.note}</p>
                            <small class="text-dark d-inline mb-1 align-middle fs-5 bill-discount-amount">-${number_format(calcSubAmount(sumDetails, addition.amount))}</small>
                        </div>
                    </li>`
                }
            });
            $('ul.bill-fees').html(feeStr)
            $('ul.bill-discounts').html(discountStr)
            totalAmount = sumDetails + feeAmount - discountAmount
            let totalStr = `
                    <li>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <p class="text-secondary d-inline mb-1 align-middle bill-total-note">Thành tiền</p>
                            <small class="text-dark d-inline mb-1 align-middle fs-5 bill-total-amount">${number_format(totalAmount)}</small>
                        </div>
                    </li>`
            if (bill.transactions.length) {
                if (totalAmount > sumTransactions) {
                    totalStr += `
                        <li>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <p class="text-secondary d-inline mb-1 align-middle bill-total-note">Đã thu</p>
                                <small class="text-dark d-inline mb-1 align-middle fs-5 bill-total-amount">${number_format(sumTransactions)}</small>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <p class="text-secondary d-inline mb-1 align-middle bill-total-note">Còn lại</p>
                                <small class="text-dark d-inline mb-1 align-middle fs-5 bill-total-amount">${number_format(totalAmount - sumTransactions)}</small>
                            </div>
                        </li>`
                } else {
                    totalStr += `
                        <li>
                            <div class="d-flex justify-content-end align-items-center mb-1">
                                <small class="text-dark d-inline mb-1 align-middle fs-5 bill-total-amount">Đã thu đủ</small>
                            </div>
                        </li>`
                }
            }
            $('ul.bill-total').html(totalStr)
            if (bill.status) {
                $('.btn-order').addClass('d-none')
                $('.btn-print').removeClass('d-none')
                let detailPrices = bill.details.map(detail => detail.price * detail.quantity),
                    transactionAmounts = bill.transactions.map(detail => detail.amount)
                if (transactionAmounts.reduce((acc, current) => acc + current, 0) >= detailPrices.reduce((acc, current) => acc + current, 0)) {
                    $('.btn-pay').addClass('d-none').next().addClass('d-none')
                } else {
                    $('.btn-pay').removeClass('d-none').next().removeClass('d-none')
                }
            } else {
                $('.btn-order').removeClass('d-none')
                $('.btn-pay').addClass('d-none').next().removeClass('d-none')
                $('.btn-print').addClass('d-none')
            }
            if (bill.details.length) {
                $('.bill-footer').removeClass('d-none')
            } else {
                $('.bill-footer').addClass('d-none')
            }
        }

        function calcSubAmount(sum, amount) {
            let money = 0
            if (amount <= 100) {
                money = sum * amount / 100
            } else {
                money = amount
            }
            return parseFloat(money)
        }

        $(document).on('click', '.btn-order', function() {
            const btn = $(this),
                bills = JSON.parse(localStorage.bills),
                bill = pickBill()
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm text-light mb-1" role="status"></span> Đang xử lý');
            syncBill(bill).done(function(response) {
                btn.prop('disabled', false).html(`<i class="bi bi-receipt"></i> Save và lên bill`);
                destroyBill(bill.id)
                bill.id = response.bill.id
                bill.status = 2
                bill.details.forEach(detail => {
                    detail.status = 1
                });
                bill.additions.forEach(addition => {
                    addition.status = 1
                });
                updateBill(bill)
                displayBill(bill)
                reloadTables()
                setTimeout(() => {
                    printBill(bill.id)
                }, 300);
            }).fail(function(errors) {
                btn.prop('disabled', false).html('<span class="text-white"><i class="bi bi-exclamation-circle-fill mt-1"></i> Thử lại');
            })
        })

        function syncBill(bill) {
            const customerId = localStorage.getItem('customer_id');
            if (customerId) {
                bill.customer_id = customerId;
            }

            bill.details.forEach(detail => {
                if (detail.product && detail.product.details) {
                    delete detail.product.details;
                }
            });
            if (bill.tables) {
                bill.tables.forEach(table => {
                    if (table.orders) {
                        delete table.orders;
                    }
                });
            }
            return $.ajax({
                data: bill,
                url: general.routes.order.sync,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
                },
                success: function(response) {
                    Toastify({
                        text: response.title,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: `var(--${response.status})`,
                    }).showToast();
                },
                error: function(errors) {
                    console.log('Error:', errors);
                    if (errors.status === 422) {
                        Toastify({
                            text: error[0],
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            backgroundColor: 'var(--danger)',
                        }).showToast();
                    } else if (errors.status === 419 || errors.status === 401) {
                        console.warn(errors.responseJSON.errors);
                        window.location.href = `{{ route('admin.login') }}`;
                    } else {
                        Swal.fire(
                            'ĐÃ CÓ LỖI XẢY RA!',
                            'Vui lòng liên hệ đơn vị phần mềm để được hỗ trợ!',
                            'error'
                        )
                    }
                }
            })
        }

        $(document).on('click', '.btn-pay', function() {
            Swal.fire({
                title: 'Hình thức thanh toán',
                text: "Chọn một hình thức thanh toán",
                icon: 'warning',
                showCancelButton: false,
                showDenyButton: true,
                confirmButtonText: 'Tiền mặt',
                confirmButtonColor: 'var(--primary)',
                denyButtonText: 'Chuyển khoản',
                denyButtonColor: 'var(--danger)'
            }).then((result) => {
                if (result.isConfirmed || result.isDenied) {
                    const bill = pickBill()
                    let price = 0,
                        prices = bill.details.map(detail => detail.price * detail.quantity),
                        note = [],
                        type = (result.isConfirmed) ? 0 : 1
                    if ($('.detail-select:checked').length) {
                        $('.detail-select:checked').each(function(index, checkbox) {
                            bill.details.forEach(detail => {
                                if (detail.id == checkbox.value) {
                                    price += detail.price * detail.quantity
                                    note.push(detail.quantity + ' ' + detail.product.name)
                                }
                            });
                        })
                    } else {
                        let totalTransactionArr = bill.transactions.map(transaction => transaction.amount),
                            sumTransactions = totalTransactionArr.reduce((acc, current) => acc + current, 0)
                        price += prices.reduce((acc, current) => acc + current, 0) - sumTransactions
                    }
                    $('.loading').removeClass('d-none')
                    console.log(bill);
                    $.ajax({
                        data: {
                            order_id: bill.id,
                            user_id: bill.user_id,
                            payment: type,
                            note: 'Bill ' + bill.id + ((note.length) ? ' thanh toán ' + note.join(', ') : ''),
                            amount: price,

                        },
                        url: general.routes.order.pay,
                        method: 'post',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(response) {
                            Toastify({
                                text: response.title,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: `var(--${response.status})`,
                            }).showToast();
                            $.get(`{{ route('admin.order', ['key' => 'getById']) }}` + '/' + bill.id, function(bill) {
                                bill.status = 2
                                bill.featured = 1
                                bill.details.forEach(detail => {
                                    detail.status = 1
                                });
                                bill.additions.forEach(addition => {
                                    addition.status = 1
                                });
                                $('.loading').addClass('d-none')
                                blurBills()
                                updateBill(bill)
                                displayBill(bill)
                            })
                            reloadTables()
                        },
                        error: function(errors) {
                            if (errors.status === 422) {
                                Toastify({
                                    text: error[0],
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: 'var(--danger)',
                                }).showToast();
                            } else if (errors.status === 419 || errors.status === 401) {
                                console.warn(errors.responseJSON.errors);
                                window.location.href = `{{ route('admin.login') }}`;
                            } else {
                                Swal.fire(
                                    'ĐÃ CÓ LỖI XẢY RA!',
                                    'Vui lòng liên hệ đơn vị phần mềm để được hỗ trợ!',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        })

        function printBill(id) {
            window.open(`{{ route('admin.order') }}/${id}/print`, '_blank',
                'toolbar=no,scrollbars=no,menubar=no,status=no,resizable=no,top=250,left=1160,width=370,height=420'
            );
        }
        $(document).on('keydown', function(e) {
            // Kiểm tra nếu phím F3 được nhấn (keyCode 114)
            if (e.key === "F3" || e.keyCode === 114) {
                e.preventDefault(); // Ngăn không cho trình duyệt thực hiện hành động mặc định của F3
                $('#order-search-input').focus(); // Focus vào ô tìm kiếm
            }
        });

        // $('.bill-detail-control:not(.d-none):last-child').click(function(e) {
        //     e.stopPropagation()
        //     console.log(true);
        // })
        $(document).on('click', '.btn-select-customer', function(e) {
            e.preventDefault();
            const customerId = $(this).attr('data-id');
            const customerName = $(this).attr('data-name');
            localStorage.setItem('customer_id', customerId);
            $('.bill-meta').append(`<br/>Khách hàng: ${customerName}`);
        });

        $(document).on('click', '.btn-booking-room', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#booking-room-form');
            form.attr('action', `{{ route('admin.order.booking') }}`);
            form.find('.modal').modal('show');
        });
        const swiperRoom = new Swiper('.rooms-swiper', {
            freeMode: true,
            loop: true,
            spaceBetween: 15,
            breakpoints: {
                375: {
                    slidesPerView: 3,
                },
                640: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 6,
                },
                1024: {
                    slidesPerView: 8,
                },
                1920: {
                    slidesPerView: 10,
                },
            },
        });


        $(document).on('click', '.btn-update-table', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#table-form');
            resetForm(form);
            $.get(`{{ route('admin.table') }}/${id}`, function(table) {
                form.find('[name="name"]').val(table.name);
                form.find('[name="note"]').val(table.note);
                form.find('[name="id"]').val(table.id);
                form.attr('action', `{{ route('admin.table.update') }}`);
                form.find('.modal').modal('show');
            })
        })

        $(document).on('click', '.btn-update-room', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#room-form');
            resetForm(form);
            $.get(`{{ route('admin.room') }}/${id}`, function(room) {
                form.find('[name="name"]').val(room.name);
                form.find('[name="note"]').val(room.note);
                form.find('[name="id"]').val(room.id);
                form.attr('action', `{{ route('admin.room.update') }}`);
                form.find('.modal').modal('show');
            })
        })

        function loadRooms() {
            $.ajax({
                url: `{{ route('admin.room.load') }}`,
                type: 'GET',
                success: function(response) {
                    $('.rooms-wrapper').html(response); // Cập nhật HTML mới vào rooms-wrapper
                    // Nếu cần thiết, bạn có thể gọi hàm khởi tạo swiper ở đây
                    const swiperRoom = new Swiper('.rooms-swiper', {
                        freeMode: true,
                        loop: true,
                        spaceBetween: 15,
                        breakpoints: {
                            375: {
                                slidesPerView: 3,
                            },
                            640: {
                                slidesPerView: 4,
                            },
                            768: {
                                slidesPerView: 6,
                            },
                            1024: {
                                slidesPerView: 8,
                            },
                            1920: {
                                slidesPerView: 10,
                            },
                        },
                    });
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }

        $(document).on('change', '.room-select', function() {
            localStorage.removeItem('customer_id');
            const id = $(this).val(),
                status = $(this).attr('data-status'),
                form = $(this).closest('form'),
                btn = form.find('[type="submit"]');

            if (status == 1) {
                $.get(`{{ route('admin.order', ['key' => 'getByRoom']) }}` + '/' + id, function(bill) {
                    console.log(bill);
                    if (bill) {
                        form.find('[name=note]').val(bill.note ? bill.note : '')
                        form.find('[name=start_time]').val(bill.room.start_time ? bill.room.start_time : '')
                        form.find('[name=end_time]').val(bill.room.end_time ? bill.room.end_time : '')
                    }
                    //Form ảo
                    var str = `<form method="post" class="save-form" id="paybooking-form" action="{{ route('admin.order.paybooking') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" /> <!-- Thêm CSRF token -->
                            <input type="hidden" name="amount" value="${bill.room.price}" />
                            <input type="hidden" name="note" value="${bill.note}" />
                            <input type="hidden" name="payment" value="0" />
                            <input type="hidden" name="order_id" value="${bill.id}" />
                        </form>`;
                    $('.paybooking-form').html(str);
                });

                btn.text('Thanh toán');
                btn.addClass('btn-paybooking');
                form.attr('action', ``);
            } else {
                btn.removeClass('btn-paybooking');
                form.attr('action', `{{ route('admin.order.booking') }}`);
                btn.text('Đặt phòng');
            }
        });

        $(document).on('click', '.btn-paybooking', function(e) {
            e.preventDefault();
            const form = $('#paybooking-form'),
                btn = $(this)
            btn.prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm text-light" role="status"></span>'
            );
            // Kiểm tra xem form có tồn tại không
            if (form.length) {
                $.ajax({
                    url: form.attr('action'), // Lấy URL từ thuộc tính action của form
                    method: 'POST', // Phương thức gửi
                    data: form.serialize(), // Chuỗi hóa dữ liệu của form
                    success: function(response) {
                        Toastify({
                            text: response.title,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            backgroundColor: `var(--bs-${response.status})`,
                        }).showToast();
                        loadRooms();
                        btn.removeClass('btn-paybooking');
                        btn.prop("disabled", false).html("Đặt phòng");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Xử lý khi gửi form thất bại
                        console.error(jqXHR, textStatus, errorThrown);
                        // alert('Có lỗi xảy ra trong quá trình thanh toán.'); // Thông báo cho người dùng
                    }
                });
            } else {
                alert('Không tìm thấy form thanh toán.');
            }
        });


        // function validAddition(amount, bill) {
        //     const totalPrice = bill.details.reduce((total, item) => {
        //         return total + (item.price * item.quantity); // Cộng dồn price nhân với quantity
        //     }, 0);


        //     const totalDiscounts = bill.additions
        //         .filter(item => item.type === 0) // Lọc các phần tử có type = 0
        //         .reduce((total, item) => {
        //             return total + parseFloat(item.amount); // Cộng dồn amount (chuyển đổi thành số nếu cần)
        //         }, 0);
        //     return totalPrice > totalDiscounts;
        // }
    });
</script>
@stack('scripts')

</html>
