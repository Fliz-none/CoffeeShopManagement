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
                <div class="col-12">
                    {{-- @if (!empty(Auth::user()->can(App\Models\User::CREATE_USER))) --}}
                        <a class="btn btn-info mb-3 block btn-create-user">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    {{-- @endif --}}
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_USERS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                {{-- @if (!empty(Auth::user()->can(App\Models\User::READ_USERS))) --}}
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
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Vai trò</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                {{-- @else
                    @include('admin.includes.access_denied')
                @endif --}}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.get = `{{ route('admin.user') }}`
        config.routes.remove = `{{ route('admin.user.remove') }}`

        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.user') }}`
                },
                columns: [
                    config.datatable.columns.checkboxes,
                    config.datatable.columns.code,
                    config.datatable.columns.name,
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    config.datatable.columns.status,
                    config.datatable.columns.action,
                ],
                pageLength: 20,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [1, 'DESC']
                ],
            })
        })
    </script>
@endpush
