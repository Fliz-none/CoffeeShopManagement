<header id="header" class="header sticky-top">
    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:storebutler6@gmail.com">storebutler6@gmail.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>0329034703</span></i>
            </div>
        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('login') }}" class="logo d-flex align-items-center">
                <h1 class="sitename">Store Butler</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Trang chủ</a></li>
                    <li><a href="#about">Về chúng tôi</a></li>
                    <li><a href="#services">Dịch vụ</a></li>
                    <li><a href="#contact">Liên hệ</a></li>
                    <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>

    </div>
</header>
