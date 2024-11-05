@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <section class="hero section light-background d-flex align-items-start" id="hero">
        <div class="container">
            <div class="d-flex">
                <a class="btn-get-started" href="#about">Get Started</a>
                <a class="glightbox btn-watch-video d-flex align-items-center bg-white px-2 rounded" href="https://www.youtube.com/watch?v=Y7f98aduVJ8"><i
                        class="bi bi-play-circle"></i><span>Xem Video</span>
                </a>
            </div>
        </div>
    </section><!-- /Hero Section -->
    <!-- About Section -->
    <section class="about section light-background" id="about">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Về chúng tôi</h2>
            <p><span>Tìm hiểu thêm</span> <span class="description-title">Về Store Butler</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-3">

                {{-- <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <img class="img-fluid" src="{{ asset('web/img/about.jpg') }}" alt="Hình ảnh về Store Butler">
                </div> --}}

                <div class="col-12 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-content ps-0 ps-lg-3">
                        <h3>Store Butler – Hệ thống quản lý chuyên nghiệp dành cho các cửa hàng ăn uống.</h3>
                        <p class="fst-italic">
                            Được thành lập bởi sáu thành viên đến từ Đại học FPT Cần Thơ, Store Butler được xây dựng với sứ mệnh cung cấp giải pháp tối ưu cho các doanh nghiệp vừa và nhỏ trong lĩnh vực ẩm thực.
                        </p>
                        <ul>
                            <li>
                                <i class="bi bi-diagram-3"></i>
                                <div>
                                    <h4>Tầm nhìn</h4>
                                    <p>Store Butler hướng tới trở thành nền tảng quản lý hàng đầu cho các doanh nghiệp vừa và nhỏ, mang lại sự tiện lợi và tối ưu hóa chi phí.</p>
                                </div>
                            </li>
                            <li>
                                <i class="bi bi-fullscreen-exit"></i>
                                <div>
                                    <h4>Sứ mệnh</h4>
                                    <p>Store Butler cam kết đồng hành cùng khách hàng với những giải pháp công nghệ thông minh, đơn giản hóa quy trình quản lý và nâng cao hiệu quả kinh doanh.</p>
                                </div>
                            </li>
                        </ul>
                        <p>
                            Mang hình ảnh của một "quản gia" tận tâm, chúng tôi cam kết cung cấp dịch vụ chất lượng cao, tiện lợi và chu đáo, giúp khách hàng quản lý cửa hàng một cách hiệu quả và đơn giản. Store Butler cam kết mang đến sự tận tâm và linh
                            hoạt, giúp các cửa hàng tối ưu chi phí và nâng cao hiệu quả, hỗ trợ doanh nghiệp phát triển bền vững và thành công.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </section><!-- /About Section -->


    <!-- Phần Kỹ Năng -->
    <section class="skills section" id="skills">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row skills-content skills-animation">

                <!-- HTML -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>HTML</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%;"></div>
                        </div>
                    </div>
                </div>

                <!-- CSS -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>CSS</span> <i class="val">85%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                        </div>
                    </div>
                </div>

                <!-- JavaScript -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>JavaScript</span> <i class="val">75%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                        </div>
                    </div>
                </div>

                <!-- PHP -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>PHP</span> <i class="val">95%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Laravel -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>Laravel Framework</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%;"></div>
                        </div>
                    </div>
                </div>

                <!-- MySQL -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>MySQL</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Git -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>Git</span> <i class="val">100%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>

                <!-- RESTful APIs -->
                <div class="col-lg-6">
                    <div class="progress">
                        <span class="skill"><span>RESTful APIs</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /Phần Kỹ Năng -->


    <!-- Stats Section -->
    <section class="stats section" id="stats">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-4 col-12 d-flex flex-column align-items-center">
                    <i class="bi bi-emoji-smile"></i>
                    <div class="stats-item">
                        <span class="purecounter" data-purecounter-start="0" data-purecounter-end="{{ count(App\Models\Company::all()) }}" data-purecounter-duration="1"></span>
                        <p>Happy Clients</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-4 col-12 d-flex flex-column align-items-center">
                    <i class="bi bi-journal-richtext"></i>
                    <div class="stats-item">
                        <span class="purecounter" data-purecounter-start="0" data-purecounter-end="1" data-purecounter-duration="1"></span>
                        <p>Projects</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-4 col-12 d-flex flex-column align-items-center">
                    <i class="bi bi-people"></i>
                    <div class="stats-item">
                        <span class="purecounter" data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1"></span>
                        <p>Hard Workers</p>
                    </div>
                </div><!-- End Stats Item -->

            </div>

        </div>

    </section><!-- /Stats Section -->

    <!-- Clients Section -->
    {{-- <section class="clients section light-background" id="clients">

        <div class="container">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                    "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                    },
                    "breakpoints": {
                    "320": {
                        "slidesPerView": 2,
                        "spaceBetween": 40
                    },
                    "480": {
                        "slidesPerView": 3,
                        "spaceBetween": 60
                    },
                    "640": {
                        "slidesPerView": 4,
                        "spaceBetween": 80
                    },
                    "992": {
                        "slidesPerView": 6,
                        "spaceBetween": 120
                    }
                    }
                }
                </script>
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-1.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-2.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-3.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-4.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-5.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-6.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-7.png') }}" alt=""></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('web/img/clients/client-8.png') }}" alt=""></div>
                </div>
            </div>

        </div>

    </section><!-- /Clients Section --> --}}

    <!-- Services Section -->
    <section class="services section" id="services">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Dịch vụ</h2>
            <p><span>Check Our</span> <span class="description-title">Dịch vụ</span></p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <a class="stretched-link" href="#">
                            <h3>Dịch vụ Năng động</h3>
                        </a>
                        <p>Đảm bảo ít sai sót và cung cấp dịch vụ vượt trội. Chúng tôi luôn cố gắng đáp ứng mọi nhu cầu của khách hàng.</p>
                    </div>
                </div><!-- Kết thúc Mục Dịch vụ -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <a class="stretched-link" href="#">
                            <h3>Phát sóng trên cả nước</h3>
                        </a>
                        <p>Chúng tôi cung cấp dịch vụ phát sóng với phạm vi cả nước, đáp ứng mọi yêu cầu của khách hàng với sự chính xác.</p>
                    </div>
                </div><!-- Kết thúc Mục Dịch vụ -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-easel"></i>
                        </div>
                        <a class="stretched-link" href="#">
                            <h3>Thị trường Sáng tạo</h3>
                        </a>
                        <p>Cung cấp giải pháp sáng tạo và hiệu quả, đảm bảo các yêu cầu của khách hàng được hoàn thành tốt nhất.</p>
                    </div>
                </div><!-- Kết thúc Mục Dịch vụ -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-bounding-box-circles"></i>
                        </div>
                        <a class="stretched-link" href="#">
                            <h3>Dịch vụ Toàn diện</h3>
                        </a>
                        <p>Đáp ứng các dịch vụ đầy đủ và hiệu quả, tạo ra giá trị lâu dài cho khách hàng.</p>
                        <a class="stretched-link" href="#"></a>
                    </div>
                </div><!-- Kết thúc Mục Dịch vụ -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <a class="stretched-link" href="#">
                            <h3>Dịch vụ Chăm sóc Khách hàng</h3>
                        </a>
                        <p>Chúng tôi cam kết cung cấp dịch vụ hỗ trợ tốt nhất, giúp khách hàng yên tâm với mọi dịch vụ.</p>
                        <a class="stretched-link" href="#"></a>
                    </div>
                </div><!-- Kết thúc Mục Dịch vụ -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-chat-square-text"></i>
                        </div>
                        <a class="stretched-link" href="#">
                            <h3>Kiến trúc Phản hồi</h3>
                        </a>
                        <p>Chúng tôi sẵn sàng lắng nghe phản hồi của khách hàng để cải thiện và đáp ứng tốt hơn nữa.</p>
                        <a class="stretched-link" href="#"></a>
                    </div>
                </div><!-- Kết thúc Mục Dịch vụ -->

            </div>

        </div>


    </section><!-- /Services Section -->

    {{-- <!-- Testimonials Section -->
    <section class="testimonials section dark-background" id="testimonials">

        <img class="testimonials-bg" src="{{ asset('web/img/testimonials-bg.jpg') }}" alt="">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
      {
        "loop": true,
        "speed": 600,
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": "auto",
        "pagination": {
          "el": ".swiper-pagination",
          "type": "bullets",
          "clickable": true
        }
      }
    </script>
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img class="testimonial-img" src="{{ asset('web/img/testimonials/testimonials-1.jpg') }}" alt="">
                            <h3>Saul Goodman</h3>
                            <h4>Ceo &amp; Founder</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum
                                    suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et.
                                    Maecen aliquam, risus at semper.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img class="testimonial-img" src="{{ asset('web/img/testimonials/testimonials-2.jpg') }}" alt="">
                            <h3>Sara Wilsson</h3>
                            <h4>Designer</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum
                                    quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat
                                    irure amet legam anim culpa.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img class="testimonial-img" src="{{ asset('web/img/testimonials/testimonials-3.jpg') }}" alt="">
                            <h3>Jena Karlis</h3>
                            <h4>Store Owner</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla
                                    quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore
                                    quis sint minim.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img class="testimonial-img" src="{{ asset('web/img/testimonials/testimonials-4.jpg') }}" alt="">
                            <h3>Matt Brandon</h3>
                            <h4>Freelancer</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim
                                    fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore
                                    quem dolore labore illum veniam.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img class="testimonial-img" src="{{ asset('web/img/testimonials/testimonials-5.jpg') }}" alt="">
                            <h3>John Larson</h3>
                            <h4>Entrepreneur</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor
                                    noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam
                                    esse veniam culpa fore nisi cillum quid.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Testimonials Section --> --}}

    <!-- Portfolio Section -->
    <section class="portfolio section" id="portfolio">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Chức năng</h2>
            <p><span>Check Our&nbsp;</span> <span class="description-title">chức năng</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <ul class="portfolio-filters isotope-filters d-none" data-aos="fade-up" data-aos-delay="100">
                    <li class="filter-active" data-filter="*">All</li>
                    <li data-filter=".filter-app">App</li>
                    <li data-filter=".filter-product">Card</li>
                    <li data-filter=".filter-branding">Web</li>
                </ul><!-- End Portfolio Filters -->

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Bán hàng</h4>
                            <p>Đặt món - Thanh toán</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-app" href="{{ asset('web/img/reviews/order.jpg') }}" title="Chức năng 1"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.order') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Cài đặt</h4>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-branding" href="{{ asset('web/img/reviews/settings.jpg') }}" title="Branding 1"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.order') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/products.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Chức năng 2</h4>
                            <p>Quản lý sản phẩm</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-product" href="{{ asset('web/img/reviews/products.jpg') }}" title="Product 1"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.product') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Quản lý hình ảnh</h4>
                            <p>Quản lý ảnh</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-app" href="{{ asset('web/img/reviews/images.jpg') }}" title="App 2"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.image') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Sản phẩm</h4>
                            <p>Chi tiết sản phẩm</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-product" href="{{ asset('web/img/reviews/product.jpg') }}" title="Product 2"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.product') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Branding 2</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-branding" href="{{ asset('web/img/reviews/order.jpg') }}" title="Branding 2"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.order') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>App 3</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-app" href="{{ asset('web/img/reviews/order.jpg') }}" title="App 3"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.order') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Product 3</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-product" href="{{ asset('web/img/reviews/order.jpg') }}" title="Product 3"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.order') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <img class="img-fluid" src="{{ asset('web/img/reviews/order.jpg') }}" alt="">
                        <div class="portfolio-info">
                            <h4>Branding 3</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a class="glightbox preview-link" data-gallery="portfolio-gallery-branding" href="{{ asset('web/img/reviews/order.jpg') }}" title="Branding 2"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a class="details-link" href="{{ route('admin.order') }}" title="More Details"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                </div><!-- End Portfolio Container -->

            </div>

        </div>

    </section><!-- /Portfolio Section -->
    <div class="z-index fixed-bottom mb-2">
        <div class="row mb-5 me-1">
            <div class="social-link text-end align-items-end justify-content-end">
                <a class="facebook" href="https://www.facebook.com/p/store-bulter-61566557390868/?locale=vi_VN"><i class="bi bi-facebook"></i></a>
                <a class="messenger mb-2" id="messengerButton" href="#"><i class="bi bi-messenger"></i></a>
            </div>
        </div>
    </div>
    <!-- Team Section -->
    {{-- <section class="team section light-background" id="team">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Team</h2>
            <p><span>Our Hardworking</span> <span class="description-title">Team</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img class="img-fluid" src="{{ asset('web/img/team/team-1.jpg') }}" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Walter White</h4>
                            <span>Chief Executive Officer</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img class="img-fluid" src="{{ asset('web/img/team/team-2.jpg') }}" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Sarah Jhonson</h4>
                            <span>Product Manager</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member">
                        <div class="member-img">
                            <img class="img-fluid" src="{{ asset('web/img/team/team-3.jpg') }}" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>William Anderson</h4>
                            <span>CTO</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-member">
                        <div class="member-img">
                            <img class="img-fluid" src="{{ asset('web/img/team/team-4.jpg') }}" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Amanda Jepson</h4>
                            <span>Accountant</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

            </div>

        </div>

    </section><!-- /Team Section --> --}}
    <!-- Pricing Section -->
    {{-- <section class="pricing section" id="pricing">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Giá</h2>
            <p><span>Check our</span> <span class="description-title">Giá</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-3">

                <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-item">
                        <h3>Miễn phí</h3>
                        <h4><sup>$</sup>0<span> / tháng</span></h4>
                        <ul>
                            <li>Truy cập cơ bản</li>
                            <li>Quản lý đơn hàng</li>
                            <li>Thống kê doanh thu</li>
                            <li class="na">Hỗ trợ khách hàng</li>
                            <li class="na">Báo cáo nâng cao</li>
                        </ul>
                        <div class="btn-wrap">
                            <a class="btn-buy" href="#">Đăng ký ngay</a>
                        </div>
                    </div>
                </div><!-- End Pricing Item -->

                <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="pricing-item featured">
                        <h3>Doanh nghiệp</h3>
                        <h4><sup>$</sup>19<span> / tháng</span></h4>
                        <ul>
                            <li>Truy cập đầy đủ</li>
                            <li>Quản lý khách hàng</li>
                            <li>Thống kê doanh thu chi tiết</li>
                            <li>Hỗ trợ qua chat</li>
                            <li class="na">Tích hợp thanh toán</li>
                        </ul>
                        <div class="btn-wrap">
                            <a class="btn-buy" href="#">Đăng ký ngay</a>
                        </div>
                    </div>
                </div><!-- End Pricing Item -->

                <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="pricing-item">
                        <h3>Nhà phát triển</h3>
                        <h4><sup>$</sup>29<span> / tháng</span></h4>
                        <ul>
                            <li>Truy cập API</li>
                            <li>Tùy chỉnh giao diện</li>
                            <li>Báo cáo chi tiết</li>
                            <li>Hỗ trợ kỹ thuật ưu tiên</li>
                            <li class="na">Tính năng nâng cao</li>
                        </ul>
                        <div class="btn-wrap">
                            <a class="btn-buy" href="#">Đăng ký ngay</a>
                        </div>
                    </div>
                </div><!-- End Pricing Item -->

                <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="pricing-item">
                        <span class="advanced">Nâng cao</span>
                        <h3>Ultimate</h3>
                        <h4><sup>$</sup>49<span> / tháng</span></h4>
                        <ul>
                            <li>Truy cập không giới hạn</li>
                            <li>Hỗ trợ 24/7</li>
                            <li>Khóa học và tài liệu hướng dẫn</li>
                            <li>Tính năng độc quyền</li>
                            <li class="na">Dịch vụ cá nhân hóa</li>
                        </ul>
                        <div class="btn-wrap">
                            <a class="btn-buy" href="#">Đăng ký ngay</a>
                        </div>
                    </div>
                </div><!-- End Pricing Item -->

            </div>

        </div>

    </section><!-- /Pricing Section --> --}}


    <!-- Faq Section -->
    <section class="faq section light-background" id="faq">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>F.A.Q</h2>
            <p><span>Các câu hỏi thường gặp</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3>Có thể tạo báo cáo doanh thu hàng ngày, hàng tuần, hoặc hàng tháng không?</h3>
                            <div class="faq-content">
                                <p>Phần mềm tự động tạo báo cáo chi tiết theo ngày, tuần, tháng, giúp bạn dễ dàng theo dõi tình hình doanh thu và đưa ra các quyết định kinh doanh phù hợp.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Làm thế nào để chăm sóc khách hàng thân thiết và tạo chương trình khuyến mãi?</h3>
                            <div class="faq-content">
                                <p>Quản lý tích điểm, phân loại khách hàng và tự động áp dụng ưu đãi, giúp bạn giữ chân khách hàng thân thiết và tăng tần suất mua hàng.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Có ứng dụng di động để quản lý từ xa không?</h3>
                            <div class="faq-content">
                                <p>Quản lý mọi lúc, mọi nơi với ứng dụng di động. Dễ dàng kiểm tra doanh thu và chăm sóc khách hàng ngay cả khi bạn đang di chuyển.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Bạn có hỗ trợ kỹ thuật không?</h3>
                            <div class="faq-content">
                                <p>Có, chúng tôi cung cấp hỗ trợ kỹ thuật 24/7 để giải đáp mọi thắc mắc và giúp bạn khắc phục sự cố nhanh chóng.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Phần mềm có thể tích hợp với các hệ thống khác không?</h3>
                            <div class="faq-content">
                                <p>Có, phần mềm của chúng tôi hỗ trợ tích hợp với nhiều hệ thống khác nhau để đảm bảo quy trình làm việc của bạn được tối ưu nhất.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                    </div>

                </div><!-- End Faq Column-->

            </div>

        </div>

    </section><!-- /Faq Section -->

    <!-- Contact Section -->
    <section class="contact section" id="contact">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p><span>Cần giúp đỡ?</span> <span class="description-title">Liên hệ chúng tôi</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-5">

                    <div class="info-wrap">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Địa chỉ</h3>
                                <p>Liên tổ 12 - 20, Hẻm 147, An Khánh, Ninh Kiều, Cần Thơ</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Số điện thoại</h3>
                                <p>0329034703</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email</h3>
                                <p>storebutler6@gmail.com</p>
                            </div>
                        </div><!-- End Info Item -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1168.008172123197!2d105.76284767940162!3d10.041963157138396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1729177316577!5m2!1svi!2s"
                            style="border:0; width: 100%; height: 270px;" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form class="php-email-form" data-aos="fade-up" data-aos-delay="200" action="{{ route('send.email') }}" method="post">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label class="pb-2" for="name-field">Tên của bạn</label>
                                <input class="form-control" id="name-field" name="name" type="text" required="">
                            </div>

                            <div class="col-md-6">
                                <label class="pb-2" for="email-field">Email của bạn</label>
                                <input class="form-control" id="email-field" name="email" type="email" required="">
                            </div>

                            <div class="col-md-12">
                                <label class="pb-2" for="subject-field">Chủ đề</label>
                                <input class="form-control" id="subject-field" name="subject" type="text" required="">
                            </div>

                            <div class="col-md-12">
                                <label class="pb-2" for="message-field">Nội dung</label>
                                <textarea class="form-control" id="message-field" name="message" rows="10" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="response-success" style="display: none;"></div>
                                <div class="response-fail" style="display: none;"></div>
                            </div>
                            <div class="col-md-12 text-center mt-3">
                                <button class="btn btn-outline-primary" type="submit"> Gửi </button>
                            </div>
                        </div>
                    </form>
                </div><!-- End Contact Form -->
            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
<style>
    .response-success {
        padding: 10px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin-top: 10px;
    }

    .response-fail {
        padding: 10px;
        background-color: #d4edda;
        color: #571515;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.php-email-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent; // Lưu lại text ban đầu của nút submit
            submitButton.disabled = true; // Disable nút submit
            submitButton.textContent = 'Đang gửi...'; // Đổi text của nút thành "Đang gửi..."

            const formData = new FormData(form);

            fetch(form.action, {
                    method: form.method,
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('.response-success').textContent = data.success;
                        document.querySelector('.response-success').style.display = 'block';
                        form.reset(); // Reset form sau khi gửi thành công
                    } else {
                        document.querySelector('.response-fail').textContent = 'Có lỗi xảy ra, vui lòng thử lại';
                        document.querySelector('.response-fail').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.querySelector('.response-fail').textContent = 'Có lỗi xảy ra, vui lòng thử lại';
                    document.querySelector('.response-fail').style.display = 'block';
                })
                .finally(() => {
                    // Khôi phục trạng thái ban đầu của nút submit sau khi hoàn thành
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                });
        });

        document.getElementById('messengerButton').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn không cho nút chuyển trang khi nhấn
            const messengerLink = `https://www.messenger.com/e2ee/t/7106585026105947`;

            // Mở liên kết trong tab mới hoặc ứng dụng Messenger
            window.open(messengerLink, '_blank');
        });
    });

</script>
