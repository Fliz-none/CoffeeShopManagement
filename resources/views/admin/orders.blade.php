@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-10">
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_ORDERS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_ORDERS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input all-choices" type="checkbox">
                                            </th>
                                            <th>Mã</th>
                                            <th>Khách hàng</th>
                                            <th>Người bán</th>
                                            <th>Thanh toán</th>
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
        config.routes.load = `{{ route('admin.order') }}`
        config.routes.remove = `{{ route('admin.order.remove') }}`
        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                dom: 'lftip',
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: config.routes.load + window.location.search
                },
                columns: [
                    config.datatable.columns.checkboxes,
                    config.datatable.columns.code,
                    config.datatable.columns.customer, {
                        data: "dealer",
                        name: "dealer",
                    }, {
                        data: "paid",
                        name: "paid",
                        className: 'text-end',
                        searchable: false,
                        sortable: false,
                    },
                    config.datatable.columns.status,
                    config.datatable.columns.action
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                scrollCollapse: false,
                scrollX: false,
                order: [
                    [1, 'DESC']
                ]
            })
        })

        $('[name=orders-branch]').change(function() {
            window.location.href = `{{ route('admin.order') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
