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
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
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
    <div class="page-content table-responsive">
        @if (!empty(Auth::user()->can(App\Models\User::READ_WORKS)))
            <style>
                @media (max-width: 992px) {
                    .card-works {
                        width: 85rem !important;
                    }
                }
            </style>
            <div class="card card-works card-body text-center w-100">
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-9 text-start">
                        <div class="d-flex">
                            <button class="btn btn-primary btn-work-sumary me-3" type="button">
                                <i class="bi bi-clipboard-plus me-1"></i>
                                Tổng kết tháng
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 p-0">
                        <div class="input-group mb-3">
                            <select class="form-control form-control-lg text-end border-0" id="month-picker"></select>
                            <select class="form-control form-control-lg text-start border-0" id="year-picker"></select>
                        </div>
                    </div>
                </div>
                <hr class="mt-0">
                <div class="calendar">
                    <div class="border-0 d-flex">
                        <div class="dayname h-25">
                            <h4 class="p-2">T2</h4>
                        </div>
                        <div class="dayname h-25">
                            <h4 class="p-2">T3</h4>
                        </div>
                        <div class="dayname h-25">
                            <h4 class="p-2">T4</h4>
                        </div>
                        <div class="dayname h-25">
                            <h4 class="p-2">T5</h4>
                        </div>
                        <div class="dayname h-25">
                            <h4 class="p-2">T6</h4>
                        </div>
                        <div class="dayname h-25">
                            <h4 class="p-2">T7</h4>
                        </div>
                        <div class="dayname h-25">
                            <h4 class="p-2">CN</h4>
                        </div>
                    </div>
                    <div id="daysmonth"></div>
                    <div class="row justify-content-end my-4 align-items-center" id="listwork"></div>
                </div>
            </div>
        @else
            @include('includes.access_denied')
        @endif
    </div>
    <style>
        @media screen and (max-width: 1199px) {
            .work-details {
                height: 60rem;
                height: auto;
            }
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#sidebar').removeClass('active');
            $(document).on('click', '.work', function() {
                maxAttendanceTime = parseInt(`{{ $settings['max_attendance_time'] }}`);
                $.get(`{{ route('admin.work.get') }}/?date=${$(this).attr('data-date')}`, function(works) {
                    var str = `<div class="table-responsive position-relative w-100"><table class="table table-border table-hover w-100"><thead><tr><th class="name fw-bold">Tên nhân viên</th>`;
                    var numberOfTime = 0;
                    while (numberOfTime < 24) {
                        var num = ('0' + numberOfTime).slice(-2)
                        str += `<th class="hour">${num}</th>`
                        numberOfTime++;
                    }
                    str += `</tr></thead><tbody>`
                    if (works.length) {
                        let workGroup = {}
                        $.each(works, function(index, work) {
                            if (!workGroup[work.user_id]) {
                                workGroup[work.user_id] = []
                            }
                            workGroup[work.user_id].push(work)
                        })
                        $.each(workGroup, function(index, works) {
                            works.sort(function(a, b) {
                                var dateA = new Date(a.created_at);
                                var dateB = new Date(b.created_at);
                                return dateA - dateB;
                            });
                            let duration = {};
                            str += `<tr>
                                    <td class="fw-bold" style="color: hsl(${makeColor(works[0].user_id)}, 100%, 50%);">${works[0].user.name}</td>
                                    <td colspan="24" class="position-relative">`
                            $.each(works, function(jndex, work) {
                                if (jndex == 0) {
                                    if (work.status == 0) {
                                        if (works.length == 1) {
                                            hour_start = moment(work.created_at).format('HH');
                                            minute_start = moment(work.created_at).format('mm');
                                            for (var i = parseInt(hour_start) + 1; i < 24; i++) {
                                                $(`.user${work.user_id}-${i}`).addClass('bg-danger')
                                            }
                                            left = moment(work.created_at).diff(
                                                moment(work.created_at).startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24)
                                            if (moment(work.created_at).format('YYYY-MM-DD') === moment().format('YYYY-MM-DD')) {
                                                width = moment().diff(moment().startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24) - left;
                                            } else {
                                                width = 100 - left
                                            }
                                            if (width <= (maxAttendanceTime / 24 * 100)) {
                                                if (moment(work.created_at).format('YYYY-MM-DD') === moment().format('YYYY-MM-DD')) {
                                                    time = moment(work.created_at).format('HH:mm') + ' - ' + moment().format('HH:mm');
                                                } else {
                                                    time = moment(work.created_at).format('HH:mm') + ' - 23:59';
                                                }
                                            } else {
                                                time = 'Chấm công không hợp lệ';
                                                width = maxAttendanceTime / 24 * 100;
                                            }
                                            str +=
                                                `<span class="badge text-white rounded-pill rounded-end work-duration cursor-pointer" data-bs-toggle="tooltip" data-bs-title="${time}" style="left: ${left}%; width: ${width}%; background: hsl(${makeColor(work.user_id)}, 100%, 50%);"> </span>`;
                                        } else {
                                            duration['in'] = work.created_at
                                        }
                                    } else { // 1
                                        left = 0;
                                        width = moment(work.created_at).diff(moment(work.created_at).startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24) - left;
                                        if (width <= (maxAttendanceTime / 24 * 100)) {
                                            time = '00:00 - ' + moment(work.created_at).format('HH:mm')
                                        } else {
                                            time = 'Chấm công không hợp lệ';
                                            width = maxAttendanceTime / 24 * 100;
                                        }
                                        str +=
                                            `<span class="badge text-white rounded-pill rounded-start work-duration cursor-pointer" data-bs-toggle="tooltip" data-bs-title="${time}" style="left: ${left}%; width: ${width}%; background: hsl(${makeColor(work.user_id)}, 100%, 50%);"> </span>`;
                                    }
                                } else if (jndex == works.length - 1) {
                                    if (work.status == 0) {
                                        left = moment(work.created_at).diff(moment(work.created_at).startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24);
                                        if (moment(work.created_at).format('YYYY-MM-DD') === moment().format('YYYY-MM-DD')) {
                                            width = moment().diff(moment().startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24) - left;
                                        } else {
                                            width = 100 - left
                                        }
                                        if (width <= (maxAttendanceTime / 24 * 100)) {
                                            if (moment(work.created_at).format('YYYY-MM-DD') === moment().format('YYYY-MM-DD')) {
                                                time = moment(work.created_at).format('HH:mm') + ' - ' + moment().format('HH:mm');
                                            } else {
                                                time = moment(work.created_at).format('HH:mm') + ' - 23:59';
                                            }
                                        } else {
                                            time = 'Chấm công không hợp lệ';
                                            width = maxAttendanceTime / 24 * 100;
                                        }
                                        str +=
                                            `<span class="badge text-white rounded-pill rounded-end work-duration cursor-pointer" data-bs-toggle="tooltip" data-bs-title="${time}" style="left: ${left}%; width: ${width}%; background: hsl(${makeColor(work.user_id)}, 100%, 50%);"> </span>`;
                                    } else { // 1
                                        duration['out'] = work.created_at
                                    }
                                } else {
                                    if (work.status == 0) {
                                        duration['in'] = work.created_at
                                    } else {
                                        duration['out'] = work.created_at
                                    }
                                }
                                if (duration['in'] && duration['out']) {
                                    left = moment(duration['in']).diff(moment(duration['in']).startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24);
                                    width = moment(duration['out']).diff(moment(duration['out']).startOf('day'), 'second') * 1000 * 100 / (1000 * 60 * 60 * 24) - left;
                                    if (width <= (maxAttendanceTime / 24 * 100)) {
                                        time = moment(duration['in']).format('HH:mm') + ' - ' + moment(duration['out']).format('HH:mm')
                                    } else {
                                        time = 'Chấm công không hợp lệ';
                                        width = maxAttendanceTime / 24 * 100;
                                    }
                                    str +=
                                        `<span class="badge text-white rounded-pill work-duration cursor-pointer" data-bs-toggle="tooltip" data-bs-title="${time}" style="left: ${left}%; width: ${width}%; background: hsl(${makeColor(work.user_id)}, 100%, 50%); height: 1rem;"> </span>`;
                                    delete duration['in'];
                                    delete duration['out'];
                                }
                            })
                            str += `</td></tr>`
                        })
                    }
                    str += `</tbody></table></div>`
                    $('.work-time').html(str);
                    $('#work-form').find('.modal').modal('show')
                })
                $('.workday').html(moment($(this).attr('data-date')).format('DD/MM/YYYY'));
            });
        });

        //Hiển thị ngày trong tháng
        function showWorkBoard([year, month]) {
            var daysInMonth = howManyDate(new Date(year, month, 0));
            var str = `<div class="week d-flex">`;
            //Lấy thứ của ngày đầu tiên trong tháng
            var firstDay = (new Date(year, month - 1, 1).getDay()) ? new Date(year, month - 1, 1).getDay() : 7;
            //Thêm các ô trống
            for (var i = 1; i < firstDay; i++) {
                str += `<div class="empty-day">
                            <div class="daybar">
                            </div>
                            <div class="dots pt-3 pb-5">
                            </div>
                        </div>`;
            }
            //In ra các nhày trong tháng
            for (var day = 1; day <= daysInMonth; day++) {
                str += `
                <div data-date="${moment(year + '-' + (( '0' + month).slice(-2)) + '-' + (( '0' + day).slice(-2))).format('YYYY-MM-DD')}" class="day work">
                    <div class="daybar ${(new Date(`${year}-${month}-${day}`).getDay() == 0) ? 'sunday' : ''}">
                        ${day}
                    </div>
                    <div class="dots mt-4">
                        <div class="mb-1 dot-date-${day}">
                        </div>
                    </div>
                </div>`;
                //Xuống dòng nếu là chủ nhật
                if ((firstDay + day) % 7 === 1) {
                    str += `</div><div class="week d-flex">`;
                }
            }

            $.get(`{{ route('admin.work.load') }}`, { month: `${$('#year-picker').val()}-${$('#month-picker').val()}` }, function(works) {
                var user_idList = [], // lưu danh sách user_id trong trong tháng\
                    user_idInDate = {} // lưu danh sách user_id trong ngày
                $.each(works, function(index, work) {
                    const dayWorked = new Date(work.created_at).getDate();
                    //nếu đã tồn tại giá trị của mảng chứa các user_id trong ngày thì kiểm tra tiếp
                    if (user_idInDate[dayWorked]) {
                        //nếu đối tuognwj user_idInDate tại vị trí dayWorked không chứa user_id thì thêm vào
                        if (!user_idInDate[dayWorked].includes(work.user_id)) {
                            user_idInDate[dayWorked].push(work.user_id)
                        }
                        //Chưa tồn tại mảng nào tại vị trí dayWorked thì tạo mới rồi thêm vào
                    } else {
                        user_idInDate[dayWorked] = []
                        user_idInDate[dayWorked].push(work.user_id)
                    }
                    if (!user_idList.includes(work.user_id)) {
                        $(`#listwork`).append(
                            `<div class="col-12 col-lg-2 text-start">
                                <div class="caldot me-2" style="background-color: hsl(${makeColor(work.user_id)}, 100%, 50%);"></div>
                                <p>${work.user.name}</p>
                            </div>`
                        )
                        user_idList.push(work.user_id)
                    }
                    //Chạy đến cuối cùng của vòng lặp rồi thêm vào các chấm màu cho bảng chấm công
                    if (index == works.length - 1) {
                        $.each(user_idInDate, function(key, values) {
                            $.each(values, function(index, value) {
                                $(`.dot-date-${key}`).append(
                                    `<div class="caldot" style="background-color: hsl(${makeColor(value)}, 100%, 50%);"></div>`
                                )
                            })
                        });
                    }

                })
            })
            $('#daysmonth').html(str);
        }


        //Tính số ngày trong tháng
        function howManyDate(dateTime) {
            switch (dateTime.getMonth() + 1) {
                case 1:
                case 3:
                case 5:
                case 7:
                case 8:
                case 10:
                case 12:
                    return 31;
                case 2:
                    if (isLeapYear(dateTime.getFullYear())) {
                        return 29;
                    } else {
                        return 28;
                    }
                case 4:
                case 6:
                case 9:
                case 11:
                    return 30;
            }
        }

        //Kiểm tra năm nhuận
        function isLeapYear(yr) {
            if (yr % 4 === 0) {
                if (yr % 100 === 0) {
                    if (yr % 400 === 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        // function initMenu() {
        //     var block = $(".day");
        //     block.addClass("clickable");
        //     block.hover(function() {
        //         window.status = $(this)
        //     }, function() {
        //         window.status = ""
        //     });

        //     $('.open').hide();
        //     block.click(
        //         function() {
        //             $(this).parents('div:eq(0)').find('.open').slideToggle('slow');
        //         }
        //     );
        // }

        let monthOptions = `<option selected hidden disabled>Chọn tháng</option>`,
            yearOptions = '<option selected hidden disabled>Chọn năm</option>';
        for (var i = 1; i <= 12; i++) {
            monthOptions += `<option value="${i}">Tháng ${i}</option>`
        }
        $('#month-picker').html(monthOptions).val(new Date().getMonth() + 1)
        for (var i = (new Date().getFullYear()) - 2; i <= (new Date().getFullYear()) + 2; i++) {
            yearOptions += `<option value="${i}">Năm ${i}</option>`
        }
        $('#year-picker').html(yearOptions).val(new Date().getFullYear())
        showWorkBoard([$('#year-picker').val(), $('#month-picker').val()])
        $('#month-picker').add('#year-picker').change(function() {
            $(`#listwork`).empty();
            showWorkBoard([$('#year-picker').val(), $('#month-picker').val()])
        })

        function makeColor(id) {
            let valColor = 0;
            valColor = (id * 31) % 360
            return valColor;
        }

        $(document).on('click', '.btn-work-sumary', function() {
            let summaryWork = [],
                count = 0
            $.get(`{{ url('quantri/work/summary') }}?month=${$('#year-picker').val()}-${$('#month-picker').val()}`, function(works) {
                $.each(works, function(index, workInAMonth) {
                    workInAMonth.sort(function(a, b) {
                        var dateA = new Date(a.created_at);
                        var dateB = new Date(b.created_at);
                        return dateA - dateB;
                    });
                    let summaryWorkTime = 0,
                        standardAttendanceTime = parseInt(
                            `{{ $settings['standard_attendance_time'] }}`),
                        attendance = {}
                    $.each(workInAMonth, function(index, work) {
                        if (index == 0) {
                            if (work.status == 1) {
                                attendance['in'] = moment(work.created_at).startOf('day')
                                    .format('YYYY-MM-DD HH:mm:ss')
                                attendance['out'] = work.created_at
                                summaryWorkTime += moment(attendance['out']).diff(moment(
                                    attendance['in']), 'minutes')
                                delete attendance['in'], delete attendance['out']
                            } else {
                                attendance['in'] = work.created_at
                            }
                        } else if (index == workInAMonth.length - 1) {
                            if (work.status == 0) {
                                if (workInAMonth[index - 1].status == 0) {
                                    attendance['out'] = moment(attendance['in']).add(
                                        standardAttendanceTime, 'hours').format(
                                        'YYYY-MM-DD HH:mm:ss')
                                    if (attendance['in'] && attendance['out']) {
                                        summaryWorkTime += moment(attendance['out']).diff(
                                            moment(attendance['in']), 'minutes')
                                        delete attendance['in'], delete attendance['out']
                                    }
                                }
                                attendance['in'] = work.created_at
                                let diff = moment(work.created_at).endOf('day').diff(moment(
                                    work.created_at), 'minutes')
                                if (diff >= standardAttendanceTime * 60) {
                                    attendance['out'] = moment(work.created_at).add(
                                        standardAttendanceTime, 'hours').format(
                                        'YYYY-MM-DD HH:mm:ss')
                                } else {
                                    attendance['out'] = moment(work.created_at).endOf('day')
                                        .format('YYYY-MM-DD HH:mm:ss')
                                }
                            } else {
                                attendance['out'] = work.created_at
                            }
                        } else {
                            if (work.status == 0) { // 0
                                if (workInAMonth[index - 1].status == 0) {
                                    attendance['out'] = moment(attendance['in']).add(
                                        standardAttendanceTime, 'hours').format(
                                        'YYYY-MM-DD HH:mm:ss')
                                    if (attendance['in'] && attendance['out']) {
                                        summaryWorkTime += moment(attendance['out']).diff(
                                            moment(attendance['in']), 'minutes')
                                        delete attendance['in'], delete attendance['out']
                                    }
                                }
                                attendance['in'] = work.created_at
                            } else { //1
                                attendance['out'] = work.created_at
                            }
                        }

                        if (attendance['in'] && attendance['out']) {
                            let inAtt = moment(attendance['in'], "YYYY-MM-DD HH:mm:ss"),
                                outAtt = moment(attendance['out'], "YYYY-MM-DD HH:mm:ss");
                            summaryWorkTime += outAtt.diff(inAtt, "minutes")
                            delete attendance['in'], delete attendance['out']
                        }
                    })
                    summaryWork.push([workInAMonth[0].user, summaryWorkTime])
                })
                let str = '';
                $.each(summaryWork, function(index, summaryForUser) {
                    str += `<tr>
                        <th scope="row">${summaryForUser[0].id}</th>
                        <td class="text-start ps-5">${summaryForUser[0].name}</td>
                        <td class="text-start">${summaryForUser[1]} phút ( ${ Math.floor((summaryForUser[1]/60)) } giờ ${ (((summaryForUser[1]/60) - Math.floor((summaryForUser[1]/60))) * 60).toFixed(0) } phút)</td>
                    </tr> `
                })
                $('.work-table').html(str);
                $('#attendance-modal').modal('show')
            })
        })
    </script>
@endpush
