<header class='mb-3'>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a class="burger-btn d-block cursor-pointer">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- {{-- @php
                    $notifications = cache()->get('notifications')
                @endphp --}}
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            <i class="bi bi-bell bi-sub fs-4"></i>
                            <span class="badge bg-danger position-absolute top-0 end-0 p-1">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-center dropdown-menu-sm-end shadow-lg notification-dropdown" aria-labelledby="dropdownMenuButton">
                            {{-- @if ($notifications->count())
                                @foreach ($notifications->take(8) as $noti)
                                    <li class="dropdown-item notification-item position-relative" data-noti-id="{{ $noti->id }}">
                                        {!! $noti->description !!}
                                    </li>
                                @endforeach
                            @else --}}
                                <li>
                                    <p class="text-center px-3 fst-italic text-nowrap">Không có thông báo nào</p>
                                </li>
                            {{-- @endif --}}
                        </ul>
                    </li>
                </ul>
                <div class="dropdown">
                    <a data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="user-menu d-flex align-items-start">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 mt-1 text-gray-600">{{ Auth::user()->name }}</h6>
                                <small class="text-secondary">{{ Auth::user()->branch ? (Auth::user()->company_id == Auth::user()->branch->company_id ? Auth::user()->branch->name : 'Không có chi nhánh') : 'Không có chi nhánh' }}</small>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ Auth::user()->avatar ? asset(env('FILE_STORAGE', '/storage')) . '/user/'. Auth::user()->avatar : asset('admin/images/logo/favicon.jpg') }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Xin chào, {{ Auth::user()->name }}</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="bi bi-person-circle me-2"></i>
                                Thông tin tài khoản
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile', ['key' => 'settings']) }}">
                                <i class="bi bi-gear-fill me-2"></i>
                                Cài đặt tài khoản
                            </a>
                        </li>
                        @if (Auth::user()->branches->count() > 1)
                            <li><a class="dropdown-item cursor-pointer btn-change-branch">
                                    <i class="bi bi-git"></i>
                                    Đổi chi nhánh
                                </a>
                            </li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('admin.profile', ['key' => 'password']) }}">
                                <i class="bi bi-shield-lock-fill me-2"></i>
                                Đổi mật khẩu
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="dropdown-item" href="{{ route('work.attendance') }}">
                                <i class="bi bi-stopwatch"></i>
                                Chấm công
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="dropdown-item" href="{{ route('admin.profile.timeorder') }}">
                                <i class="bi bi-calendar2-week"></i>
                                Sắp lịch làm việc
                            </a>
                        </li>
                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>Đăng xuất</a>
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
