@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageName }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
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
                <div class="col-12">
                    <a class="btn btn-info mb-3 block btn-create-table bg-primary">
                        <i class="bi bi-plus-circle"></i>
                        Thêm Khách Hàng
                    </a>
                    <div class="d-inline-block process-btns d-none">
                        <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                            <i class="bi bi-trash"></i>
                            Xoá
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
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
                                        <th>Tên</th>
                                        <th>Số Điện Thoại</th>
                                        <th>Cấp Độ</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.remove = `{{ route('admin.customer.remove') }}`

        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.customer') }}`,
                    type: 'GET',
                    dataType: 'json',
                    error: function(err) {
                        if (err.status == 401 || err.status == 419) {
                            console.warn(err.responseJSON.errors);
                            window.location.href = "{{ url('login') }}";
                        } else {
                            console.log('Error:', err);
                            swal(`{{ __('ĐÃ CÓ LỖI XẢY RA!') }}`, err.responseJSON.$message, 'error');
                        }
                    }
                },
                columns: [
                    config.datatable.columns.checkboxes, // Giả sử bạn đã định nghĩa cột checkbox ở nơi khác
                    {
                        data: 'code',
                        name: 'code',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'level',
                        name: 'level',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
            });

            $(document).on('click', '.btn-create-customer', function(e) {
                e.preventDefault();
                resetForm($('#customer-form')) // Đảm bảo form đúng
                $('#customer-form').attr('action', `{{ route('admin.customer.create') }}`);
                $('#customer-modal').modal('show');
            });

            $(document).on('click', '.btn-update-customer', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#customer-form');
                resetForm(form);
                $.get(`{{ route('admin.customer') }}/${id}`, function(customer) {
                    console.log(customer);
                    form.find('[name="name"]').val(customer.name);
                    form.find('[name="phone"]').val(customer.phone);
                    form.find('[name="level"]').val(customer.level);
                    form.find('[name="id"]').val(customer.id);
                    form.attr('action', `{{ route('admin.customer.update') }}`);
                    form.find('.modal').modal('show');
                });
            });
        });
    </script>
@endpush
