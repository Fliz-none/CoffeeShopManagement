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
                    {{-- <a class="btn btn-info mb-3 block btn-create-transaction bg-primary">
                        <i class="bi bi-plus-circle"></i>
                        Thêm
                    </a> --}}
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
                                        <th>Mã Đơn Hàng</th>
                                        <th>Khách Hàng</th>
                                        <th>Nhân Viên Thu Ngân</th>
                                        <th>Phương Thức Thanh Toán</th>
                                        <th>Số Tiền</th>
                                        <th>Ngày</th>
                                        <th>Ghi Chú</th>
                                        <th></th>
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
        config.routes.remove = `{{ route('admin.transaction.remove') }}`;

        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.transaction') }}`,
                    type: 'GET',
                    dataType: 'json',
                    error: function(err) {
                        if (err.status == 401 || err.status == 419) {
                            console.warn(err.responseJSON.errors);
                            window.location.href = "{{ url('login') }}";
                        } else {
                            console.log('Error:', err);
                            swal(`{{ __('ĐÃ CÓ LỖI XẢY RA!') }}`, err.responseJSON.message, 'error');
                        }
                    }
                },
                columns: [
                    { data: 'order_id', name: 'order_id' },
                    { data: 'customer_id', name: 'customer_id' },
                    { data: 'cashier_id', name: 'cashier_id' },
                    { data: 'payment', name: 'payment' },
                    { data: 'amount', name: 'amount' },
                    { data: 'date', name: 'date' },
                    { data: 'note', name: 'note' },
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
            });

            $(document).on('click', '.btn-create-transaction', function(e) {
                e.preventDefault();
                resetForm($('#transaction-form'))
                $('#transaction-form').attr('action', `{{ route('admin.transaction.create') }}`)
                $('#transaction-modal').modal('show');
            })
            $(document).on('click', '.btn-update-transaction', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#transaction-form');
                resetForm(form);
                $.get(`{{ route('admin.transaction') }}/${id}`, function(transaction) {
                    form.find('[name="order_id"]').val(transaction.order_id);
                    form.find('[name="customer_id"]').val(transaction.customer_id);
                    form.find('[name="cashier_id"]').val(transaction.cashier_id);
                    form.find('[name="payment"]').val(transaction.payment);
                    form.find('[name="amount"]').val(number_format(transaction.amount));
                    form.find('[name="date"]').val(transaction.date);
                    form.find('[name="note"]').val(transaction.note);
                    form.find('[name="id"]').val(transaction.id);
                    form.attr('action', `{{ route('admin.transaction.update') }}`);
                    form.find('.modal').modal('show');
                })
            })
        })
    </script>
@endpush
