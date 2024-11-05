@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3> {{ $pageName }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first d-flex justify-content-end align-items-end">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                                    <p class="text-light-primary">Bảng tin</p>
                                </a></li>
                            <li class="breadcrumb-item text-dark active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        @if (!empty(Auth::user()->can(App\Models\User::CREATE_WORK)))
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="data-table">
                            <thead>
                                <tr>
                                    <th class="cursor-pointer">ID</th>
                                    <th class="cursor-pointer">Nhân viên</th>
                                    <th class="cursor-pointer">Ảnh</th>
                                    <th class="cursor-pointer">Trạng Thái</th>
                                    <th class="cursor-pointer">Thời gian</th>
                                    <th class="cursor-pointer">Ghi chú</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @else
        @include('admin.includes.access_denied')
        @endif
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('work.loadList') }}`,
                    error: function(err) {
                        if (err.status = 401 || err.status == 419) {
                            console.warn(err.responseJSON.errors);
                            window.location.href - "{{ url('login') }}";
                        } else {
                            console.log('Error:', err);
                            swal('{{ _(' ĐÃ CÓ LỖI XẢY RA! ') }}', err.responseJSON.message, 'error');
                        }
                    },
                },
                columns: [{
                    data: 'id',
                    name: 'id'
                }, {
                    data: 'user_id',
                    name: 'user_id'
                }, {
                    data: 'image',
                    name: 'image',
                }, {
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }, {
                    data: 'note',
                    name: 'note'
                }],
                language: {
                    "sProcessing": "Đang xử lý...",
                    "sLengthMenu": "_MENU_ dòng /  trang",
                    "sZeroRecords": "Không có nội dung.",
                    "sInfo": "Từ _START_ đến _END_ của _TOTAL_ mục",
                    "sInfoEmpty": "Không có mục nào",
                    "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                    'searchPlaceholder': "Tìm kiếm dữ liệu",
                    "sInfoPostFix": "",
                    "sSearch": "",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "&laquo;",
                        "sPrevious": "&lsaquo;",
                        "sNext": "&rsaquo;",
                        "sLast": "&raquo;",
                    },
                },
                columnDefs: [{
                    target: 0,
                    sortable: false,
                    searchable: false,
                }],
                order: [
                    [1, 'desc']
                ]
            })

            $(document).on('click', '.btn-update-work', function() {
                const id = $(this).attr('data-id'),
                    maxAtt = `{{ $settings['max_attendance_time'] }}`,
                    standardAtt = `{{ $settings['standard_attendance_time'] }}`,
                    form = $('#update-work-form');
                resetForm(form)
                form.attr('action', `{{ route('admin.work.update') }}`)
                $.get(`{{ route('admin.work.get') }}/?id=${id}`, function(workLists) {
                    if (workLists.workAfter == null) {
                        workLists.workAfter = JSON.parse(JSON.stringify(workLists.work));
                        workLists.workAfter.created_at = moment(new Date(workLists.work.created_at))
                            .add(standardAtt, 'hours').format("YYYY-MM-DD HH:mm");
                    }
                    if (workLists.workBefore == null) {
                        workLists.workBefore = JSON.parse(JSON.stringify(workLists.work));
                        workLists.workBefore.created_at = moment(new Date(workLists.work
                            .created_at)).subtract(standardAtt, 'hours').format(
                            "YYYY-MM-DD HH:mm");
                    }
                    console.log(workLists.workBefore.created_at);
                    console.log(workLists.workAfter.created_at);
                    let duration = (moment(new Date(workLists.workAfter.created_at)) - moment(new Date(workLists.workBefore.created_at))) / (1000 * 60),
                        right = (moment(new Date(workLists.workAfter.created_at)) - moment(new Date(workLists.work.created_at))) / (1000 * 60);
                            if ((right / 60) > standardAtt) {
                                right = standardAtt * 60 / 2;
                                workLists.workAfter.created_at = moment(new Date(workLists.work.created_at))
                            .add(standardAtt / 2, 'hours').format("YYYY-MM-DD HH:mm");
                            }
                            let left = duration - right;
                            if ((left / 60) > standardAtt) {
                                left = standardAtt * 60 / 2;
                                workLists.workBefore.created_at = moment(new Date(workLists.work.created_at))
                            .subtract(standardAtt / 2, 'hours').format("YYYY-MM-DD HH:mm");
                            }
                            duration = left + right;
                    value = 100 * left / duration;
                    console.log(workLists.workBefore.created_at);
                    console.log(workLists.workAfter.created_at, duration);
                    $('.time-before').val(moment(workLists.workBefore.created_at).format(
                        "YYYY-MM-DD HH:mm")).next().val(duration);
                    $('.work-attendance').html(
                        `<label for="work-range" class="form-label"></label>
                        <input type="range" min="0" max="100" step="1" class="form-range" id="work-range" value="${value}">`
                    );
                    $('.work-date').html(
                        `<span>${moment(workLists.work.created_at).format("YYYY-MM-DD HH:mm")}</span>`
                    );
                    $('.work-employee').text(workLists.work.user.name)
                    form.find('[name=id]').val(id);
                    form.find('[name=work_created_at]').val(moment(workLists.work.created_at).format("YYYY-MM-DD HH:mm"));
                });
                form.find('.modal').modal('show');
            })

            $('.work-attendance').on('change', function() {
                var dateTime = moment(new Date($('.time-before').val())).add(($(
                        '#work-range').val() * $('.duration').val() / 100).toFixed(0),
                    'minutes').format("YYYY-MM-DD HH:mm");
                $('.work-date').html(`<span>${dateTime}</span>`);
                $('#update-work-form').find('[name=work_created_at]').val(dateTime);
            })
        });
    </script>
@endpush
