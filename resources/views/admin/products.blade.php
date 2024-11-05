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
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-md-6">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_PRODUCT)))
                        <a class="btn btn-info mb-3 block" href="{{ route('admin.product', ['key' => 'new']) }}">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::UPDATE_PRODUCT)))
                        <button class="btn btn-primary mb-3 btn-sort ms-2" type="button">
                            <i class="bi bi-filter-left"></i>
                            Sắp xếp
                        </button>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        <a class="btn btn-primary btn-barcode-product mb-3 ms-2" type="button">
                            <i class="bi bi-upc-scan"></i>
                            Mã vạch
                        </a>
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_PRODUCTS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_PRODUCTS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="products-datatable">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input all-choices" type="checkbox">
                                            </th>
                                            <th>STT</th>
                                            <th>Mã</th>
                                            <th>Ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                @else
                    @include('admin.includes.access_denied')
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.get = `{{ route('admin.product') }}`
        config.routes.sort = `{{ route('admin.product.sort') }}`
        config.routes.remove = `{{ route('admin.product.remove') }}`

        const table = $('#products-datatable').DataTable({
            dom: 'lftip',
            bStateSave: true,
            stateSave: true,
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data export', // Tiêu đề của file Excel
                text: 'Xuất Excel' // Văn bản hiển thị trên nút
            }],
            ajax: {
                url: `{{ route('admin.product') }}`
            },
            columns: [
                config.datatable.columns.checkboxes,
                config.datatable.columns.sort,
                config.datatable.columns.code, {
                    data: 'avatar',
                    name: 'avatar'
                },
                config.datatable.columns.name, {
                    data: 'catalogues',
                    name: 'catalogues'
                },
                config.datatable.columns.status,
                config.datatable.columns.action,
            ],
            pageLength: config.datatable.pageLength,
            aLengthMenu: config.datatable.lengths,
            language: config.datatable.lang,
            columnDefs: config.datatable.columnDefines,
            order: [
                [1, 'ASC']
            ],
        })
    </script>
@endpush
