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
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered key-table" id="log-table">
                            <thead>
                                <tr>
                                    <th>Người Dùng</th>
                                    <th>Hành Động</th>
                                    <th>Loại</th>
                                    <th>Đối Tượng</th>
                                    <th>Vị Trí Địa Lý</th>
                                    <th>Thiết Bị</th>
                                    <th>Ngày Thực Hiện</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#log-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.log') }}`, // Đảm bảo tạo route 'admin.log' để truy vấn log
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
                    { data: 'user_id', name: 'user_id' },
                    { data: 'action', name: 'action' },
                    { data: 'type', name: 'type' },
                    { data: 'object', name: 'object' },
                    { data: 'geolocation', name: 'geolocation' },
                    { data: 'device', name: 'device' },
                    { data: 'created_at', name: 'created_at' },  // Giả sử 'created_at' là ngày thực hiện log
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
            });
        });
    </script>
@endpush
