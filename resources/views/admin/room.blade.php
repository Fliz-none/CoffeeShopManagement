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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng tin</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_TABLE)))
                    <a class="btn btn-info mb-3 block btn-create-room bg-primary">
                        <i class="bi bi-plus-circle"></i>
                        Thêm
                    </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_TABLES)))
                        <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                            <i class="bi bi-trash"></i>
                            Xoá
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_TABLES)))
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
                                        <th>Ghi chú</th>
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
        config.routes.remove = `{{ route('admin.room.remove') }}`

        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data export', // Tiêu đề của file Excel
                        text: 'Xuất Excel' // Văn bản hiển thị trên nút
                    }
                ],
                ajax: {
                    url: `{{ route('admin.room') }}`,
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
                    config.datatable.columns.checkboxes,
                    config.datatable.columns.code,
                    config.datatable.columns.name,
                    config.datatable.columns.note,
                    config.datatable.columns.status,
                    config.datatable.columns.action,
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
            });

            $(document).on('click', '.btn-create-room', function(e) {
                console.log('a');
                e.preventDefault();
                resetForm($('#room-form'))
                $('#room-form').attr('action', `{{ route('admin.room.create') }}`)
                $('#room-modal').modal('show');
            })
            $(document).on('click', '.btn-update-room', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#room-form');
                resetForm(form);
                $.get(`{{ route('admin.room') }}/${id}`, function(room) {
                    console.log(room);
                    form.find('[name="name"]').val(room.name);
                    form.find('[name="note"]').val(room.note);
                    form.find('[name="id"]').val(room.id);
                    form.attr('action', `{{ route('admin.room.update') }}`);
                    form.find('.modal').modal('show');
                })
            })
        })
    </script>
@endpush