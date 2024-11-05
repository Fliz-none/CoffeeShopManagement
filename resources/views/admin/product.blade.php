@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Các sản phẩm</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
        @if (session('response') && session('response')['status'] == 'success')
            <div class="alert bg-success alert-dismissible fade show text-white" role="alert">
                <i class="fas fa-check"></i>
                {!! session('response')['msg'] !!}
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
        @elseif (session('response'))
            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <i class="fa-solid fa-xmark"></i>
                {!! session('response')['msg'] !!}
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <i class="fa-solid fa-xmark"></i>
                    {{ $error }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        <section class="section">
            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_PRODUCT, App\Models\User::CREATE_PRODUCT)))
                <form id="product-form" action="{{ route('admin.product.save') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-9 mx-auto">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Tên gọi của sản phẩm dùng để phân biệt nó với các sản phẩm khác" for="product-name">Tên sản phẩm</label>
                                            <input class="form-control @error('name') is-invalid @enderror" id="product-name" name="name" type="text" value="{{ old('name') != null ? old('name') : (isset($product) ? $product->name : '') }}">
                                            @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Giá bán của sản phẩm" for="product-price">Giá bán</label>
                                            <input class="form-control money @error('price') is-invalid @enderror" id="product-price" name="price" type="text" value="{{ old('price') != null ? old('price') : (isset($product) ? $product->price : '') }}">
                                            @error('price')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label data-bs-toggle="tooltip" data-bs-title="Thông tin ngắn gọn của sản phẩm" for="product-excerpt">Mô tả ngắn</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" id="product-excerpt" name="excerpt" rows="3">{{ old('excerpt') != null ? old('excerpt') : (isset($product) ? $product->excerpt : '') }}</textarea>
                                    @error('excerpt')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label data-bs-toggle="tooltip" data-bs-title="Mô tả chi tiết các đặc điểm và công dụng của sản phẩm" for="product-description">Nội dung sản phẩm</label>
                                    @error('description')
                                        <span class="invalid-feedback d-inline-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <textarea class="form-control summernote @error('description') is-invalid @enderror" id="product-description" name="description" rows="1">{{ old('description') != null ? old('description') : (isset($product) ? $product->description : '') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label data-bs-toggle="tooltip" data-bs-title="Bộ hình ảnh của sản phẩm" for="product-images">Gallery ảnh sản phẩm</label>
                                    <input id="product-images" name="gallery" type="hidden" value="{{ old('gallery') != null ? old('gallery') : (isset($product) ? $product->gallery : '') }}">
                                    <div class="row gallery align-items-center pt-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 mx-auto">
                            <!-- Publish card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Đăng bài</h6>
                                <hr class="horizontal dark">
                                <div class="form-group">
                                    <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Tình trạng hiện tại của sản phẩm trong hệ thống" for="product-status">Trạng thái</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="product-status" name="status">
                                        <option value="1" {{ (isset($product) && $product->status == 1) || old('status') == 1 ? 'selected' : '' }}>Đang bán</option>
                                        <option value="0" {{ (isset($product) && $product->status == 0) || old('status') === '0' ? 'selected' : '' }}>Bị khóa</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="product-date">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control @error('date') is-invalid @enderror" id="product-date" name="date" type="date"
                                            value="{{ old('date') != null ? old('date') : (isset($product) ? $product->createdDate() : Carbon\Carbon::now()->format('Y-m-d')) }}" aria-label="Ngày">
                                        <input class="form-control @error('time') is-invalid @enderror" id="product-time" name="time" type="time"
                                            value="{{ old('time') != null ? old('time') : (isset($product) ? $product->createdTime() : Carbon\Carbon::now()->format('H:i:s')) }}" aria-label="Giờ">
                                    </div>
                                </div>
                                @error('date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('time')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input id="product-deleted_at" name="deleted_at" type="hidden" value="{{ isset($product) ? $product->deleted_at : '' }}">
                                <input id="product-id" name="id" type="hidden" value="{{ isset($product) ? ($product->revision ? $product->revision : $product->id) : '' }}">
                                <button class="btn btn-info" type="submit">{{ isset($product) ? 'Cập nhật' : 'Đăng sản phẩm' }}</button>
                                <a class="btn btn-link" href="{{ route('admin.product') }}" type="button">Trở về danh sách</a>
                            </div>
                            <!-- END Publish card -->

                            <!-- Catalog card -->
                            <div class="card card-body mb-3">
                                <div class="input-group search-container">
                                    <label class="form-label d-flex align-items-center text-info mb-0 me-3" data-bs-toggle="tooltip" data-bs-title="Dùng để phân loại các sản phẩm thành các nhóm" for="product-catalogue-select">Danh mục</label>
                                    <div class="w-25">
                                        <a class="btn btn-outline-primary btn-sm btn-refresh-catalogue rounded-pill">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </a>
                                    </div>
                                    <input class="form-control search-input ms-3" id="product-catalogue-select" type="text" placeholder="Tìm kiếm...">
                                </div>
                                <hr class="horizontal dark">
                                <div class="catalogue-select search-item overflow-auto" style="max-height: 450px">
                                    <ul class="list-group search-list">
                                        @include('admin.includes.catalogue_recursion', [
                                            'catalogues' => $catalogues,
                                            'product' => isset($product) ? $product : null,
                                        ])
                                    </ul>
                                </div>
                                @error('catalogues')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <a class="btn btn-sm btn-link mt-3 btn-create-catalogue">Thêm danh mục</a>
                            </div>
                            <!-- END Catalog card -->
                        </div>
                    </div>
                </form>
            @else
                @include('admin.includes.access_denied')
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            viewProductImages()

            $('#product-name').keyup(function() {
                $('.head-name').text($(this).val());
            })

            $(document).on('click', '.add-gallery', function() {
                openQuickImages('product-images', false)
            })

            $('[type=submit]').click(function() {
                $(this).prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>')
                    .parents('form').submit()
            })

            $('#product-images').change(function() {
                viewProductImages()
            })

            function viewProductImages() {
                let text = ''
                $.each($('#product-images').val().split('|'), function(index, image) {
                    if (image != '') {
                        text += `
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="card card-image text-bg-dark mb-2">
                            <button type="button" class="btn-close btn-remove-images" data-index="${index}" aria-label="Close"></button>
                            <div class="ratio ratio-1x1">
                                <img src="{{ asset(env('FILE_STORAGE', '/storage')) }}/${image}" class="card-img img-gallery thumb cursor-pointer">
                            </div>
                        </div>
                    </div>`;
                    } else {
                        text += `
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                            <i class="bi bi-plus"></i>
                        </div>
                    </div>`;
                    }
                })
                $('.row.gallery').html(text);
            }
        });
    </script>
@endpush
