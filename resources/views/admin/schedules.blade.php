@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <!-- Thêm jQuery UI CSS -->
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <!-- Thêm jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
                    <a class="btn btn-info mb-3 block btn-create-schedule bg-primary">
                        <i class="bi bi-plus-circle"></i>
                        Thêm
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
                                        <th>Nhân viên</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
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
        config.routes.remove = `{{ route('admin.schedule.remove') }}`;

        $(document).ready(function() {
            const table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data export', // Tiêu đề của file Excel
                    text: 'Xuất Excel' // Văn bản hiển thị trên nút
                }],
                ajax: {
                    url: `{{ route('admin.schedule') }}`,
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
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    // {
                    //     data: 'slot',
                    //     name: 'slot'
                    // },
                    config.datatable.columns.action,
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
            });

            $(document).on('click', '.btn-create-schedule', function(e) {
                e.preventDefault();
                resetForm($('#schedule-form'));
                const slotContainer = $('#slot-container');
                slotContainer.empty(); // Xóa tất cả các slot cũ
                $('#schedule-form').attr('action', `{{ route('admin.schedule.create') }}`);
                $('#schedule-modal').modal('show');
            });

            $(document).on('click', '.btn-update-schedule', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#schedule-form');
                resetForm(form);
                $.get(`{{ route('admin.schedule') }}/${id}`, function(schedule) {
                    console.log(schedule);
                    form.find('[name="date"]').val(moment(schedule.start_time).format('YYYY-MM-DD'));
                    form.find('[name="slot"]').parent().addClass('d-none');
                    form.find('[name="id"]').val(schedule.id);
                    form.find('[name="user_id"]').val(schedule.user_id);
                    form.attr('action', `{{ route('admin.schedule.update') }}`);

                    // Lấy giờ từ start_time và end_time
                    var startHour = moment(schedule.start_time).hours();
                    var endHour = moment(schedule.end_time).hours();

                    if (endHour === 0 && moment(schedule.end_time).isAfter(moment(schedule.start_time), 'day')) {
                        endHour = 24;
                    }
                    // Hiển thị slider với giá trị dựa trên start_time và end_time
                    $('#slot-container').html(`
                        <div class="slot-item">
                            <label>Slot 1</label>
                            <div id="slider-1"></div>
                            <div class="slider-label">
                                <span class="start-time">${startHour}h</span>
                                <span class="end-time">${endHour}h</span>
                            </div>
                        </div>`);

                    const slider = $(`#slider-1`);
                    slider.slider({
                        range: true,
                        min: 0,
                        max: 24,
                        values: [startHour, endHour],
                        slide: function(event, ui) {
                            $(this).closest('.slot-item').find('.start-time').text(ui.values[0] + 'h');
                            $(this).closest('.slot-item').find('.end-time').text(ui.values[1] + 'h');
                        },
                    });

                    form.find('.modal').modal('show');
                });
            });

            $('#schedule-slot').on('input', function() {
                const slotContainer = $('#slot-container');
                slotContainer.empty(); // Xóa tất cả các slot cũ

                var numSlots = parseInt($(this).val());

                if (isNaN(numSlots)) {
                    numSlots = 1;
                }
                // Kiểm tra nếu số slot là hợp lệ
                if (!isNaN(numSlots) && numSlots > 0 && Number.isInteger(numSlots)) {
                    for (let i = 1; i <= numSlots; i++) {
                        // Tạo phần tử HTML cho mỗi slot
                        const slotItem = $(`
                    <div class="slot-item">
                        <label>Slot ${i}</label>
                        <div id="slider-${i}"></div>
                        <div class="slider-label">
                            <span class="start-time">0h</span>
                            <span class="end-time">24h</span>
                        </div>
                    </div>
                `);

                        // Tạo slider với hai nút điều khiển
                        const slider = slotItem.find(`#slider-${i}`);
                        var numSlotVals = parseInt($(this).val());
                        slider.slider({
                            range: true,
                            min: 0,
                            max: 24,
                            values: [0, 24],
                            slide: function(event, ui) {
                                $(this).closest('.slot-item').find('.start-time').text(ui.values[0] + 'h');
                                $(this).closest('.slot-item').find('.end-time').text(ui.values[1] + 'h');
                            },
                            stop: function(event, ui) {
                                validateSlots(numSlotVals); // Kiểm tra chồng lấn khi ngừng kéo slider
                            }
                        });

                        slotContainer.append(slotItem);
                    }
                }
            });

            $(document).on('submit', '#schedule-form', function(e) {
                var numSlots = parseInt($('#schedule-slot').val());
                // Gọi hàm validateSlots và kiểm tra nếu có chồng lấn
                if (validateSlots(numSlots)) {
                    e.preventDefault(); // Ngăn không cho gửi form
                } else {
                    // Cập nhật giá trị cho trường ẩn
                    const slotTimes = [];
                    if (isNaN(numSlots)) {
                        const slider = $(`#slider-1`);
                        const start = slider.slider("values", 0);
                        const end = slider.slider("values", 1);
                        slotTimes.push(`${start}-${end}`); // Ví dụ: "0-24"
                    } else {
                        for (let i = 1; i <= numSlots; i++) {
                            const slider = $(`#slider-${i}`);
                            const start = slider.slider("values", 0);
                            const end = slider.slider("values", 1);
                            slotTimes.push(`${start}-${end}`); // Ví dụ: "0-24"
                        }

                    }
                    $('#slot-times').val(JSON.stringify(slotTimes)); // Lưu dưới dạng JSON
                }


            });


        });

        function validateSlots(numSlots) {
            const ranges = []; // Lưu trữ khoảng thời gian của từng slot
            // Lưu khoảng thời gian cho từng slot
            for (let i = 1; i <= numSlots; i++) {
                const slider = $(`#slider-${i}`);
                const start = slider.slider("values", 0);
                const end = slider.slider("values", 1);
                ranges.push({
                    start,
                    end
                });
            }

            const overlaps = []; // Mảng lưu thông báo chồng lấn

            // Kiểm tra sự chồng lấn giữa các slot
            for (let i = 0; i < ranges.length; i++) {
                for (let j = i + 1; j < ranges.length; j++) {
                    if (ranges[i].start < ranges[j].end && ranges[i].end > ranges[j].start) {
                        overlaps.push(`Slot ${i + 1} và Slot ${j + 1} có sự chồng lấn.`);
                    }
                }
            }

            // Hiển thị thông báo nếu có sự chồng lấn
            if (overlaps.length > 0) {
                pushToastify(overlaps.join("\n"), 'warning');
                return true; // Trả về true nếu có chồng lấn
            }
            return false; // Trả về false nếu không có chồng lấn
        }
    </script>
@endpush
