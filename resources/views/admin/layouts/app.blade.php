<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') - {{ config('app.name') }}</title>

    {{-- Định nghĩa web app --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    {{-- Ảnh hiển thị khi thêm vào màn hình Home --}}
    {{-- <link href="{{ asset('admin/images/logo/favicon.jpg') }}" rel="apple-touch-icon"> --}}
    <link type="image/x-icon" href="{{ Auth::user()->company->favicon_url ?? asset('admin/images/logo/favicon.jpg') }}" rel="shortcut icon">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    {{-- <link href="{{ asset('admin/vendors/bootstrap5.3.3/css/bootstrap.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/key.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/pos/css/work.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet">

    <script src="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/bootstrap5.3.3/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    {{-- input image JSCompressor --}}
    <script src="{{ asset('admin/vendors/compressorjs/compressor.min.js') }}"></script>
    {{-- Include Select2 CSS --}}
    <link href="{{ asset('admin/vendors/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
    {{-- Toastify --}}
    <link href="{{ asset('admin/vendors/toastify/toastify.css') }}" rel="stylesheet">
    {{-- ChartJS --}}
    <link href="{{ asset('admin/vendors/chartjs/Chart.min.css') }}" rel="stylesheet">
    {{-- Include sweetalert2 --}}
    <link href="{{ asset('admin/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    {{-- Print JS --}}
    <link href="{{ asset('admin/vendors/print/print.min.css') }}" rel="stylesheet">
    {{-- Include Summernote Editor --}}
    <link href="{{ asset('admin/vendors/summernote/summernote-lite.min.css') }}" rel="stylesheet">

    <link type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css"
        rel="stylesheet" />
    {{-- Include moment JS --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/moment.min.js"></script>
    {{-- Include sweetalert2 JS --}}
    <script src="{{ asset('admin/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- Include daterange picker JS --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $(window).on('offline', function() {
                $('.loading').removeClass('d-none');
                Swal.fire("Thông báo!", 'Bạn bị mất kết nối internet', "info");
            });
            // Bắt sự kiện khi có mạng trở lại
            $(window).on('online', function() {
                $('.loading').addClass('d-none');
                Swal.close();
            });
        })
    </script>
</head>

<body>
    <div id="app">
        @include('admin.includes.sidebar')
        <div class='layout-navbar' id="main">
            @include('admin.includes.header')
            <div id="main-content">
                @yield('content')
                @include('admin.includes.footer')
            </div>
            @include('admin.includes.partials.modal_role')
            @include('admin.includes.partials.modal_user')
            @include('admin.includes.partials.modal_image')
            @include('admin.includes.partials.modal_sort')
            @include('admin.includes.partials.modal_room')
            @include('admin.includes.partials.modal_table')
            @include('admin.includes.partials.modal_customer')
            @include('admin.includes.partials.modal_catalogue')
            @include('admin.includes.partials.modal_schedule')
            @include('admin.includes.partials.modal_work')
            @include('admin.includes.partials.modal_work_management')
            @include('admin.includes.partials.modal_company')
            @include('admin.includes.partials.modal_attendance')
            @if (Request::path() != 'quantri/image')
                <div class="modal fade" id="quick_images-modal" aria-labelledby="quick_images-label" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            @include('admin.includes.quick_images')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="d-none" id="print-wrapper"></div>
    <div class="d-none" id="render-wrapper"></div>
    <div class="loading d-none">
        <div class="spinner card">Đang xử lý...</div>
    </div>
</body>
<script script src="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
{{-- DataTables --}}
<script src="{{ asset('admin/vendors/datatables/datatables2.0.8.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>
<link href="{{ asset('admin/vendors/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/vendors/datatables/button/buttons.bootstrap5.css') }}" rel="stylesheet">
<link href="{{ asset('admin/vendors/datatables/button/buttons.dataTables.css') }}" rel="stylesheet">
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('admin/vendors/datatables/button/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables/button/vfs_fonts.js') }}"></script>
{{-- Include ChartJS --}}
<script src="{{ asset('admin/vendors/chartjs/Chart.min.js') }}"></script>
{{-- Include Toastify --}}
<script src="{{ asset('admin/vendors/toastify/toastify.js') }}"></script>
{{-- Include MomentJS --}}
<script src="{{ asset('admin/vendors/momentjs/moment.min.js') }}"></script>
{{-- Include sweetalert2 --}}
<script src="{{ asset('admin/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
{{-- Include select2 --}}
<script src="{{ asset('admin/vendors/select2/js/select2.full.js') }}"></script>
<script src="{{ asset('admin/vendors/select2/js/i18n/vi.js') }}"></script>
{{-- Include Summernote Editor --}}
<script src="{{ asset('admin/vendors/summernote/summernote-lite.min.js') }}"></script>
{{-- input mask js --}}
<script src="{{ asset('admin/vendors/jquery-mask/jquery.mask.js') }}"></script>
{{-- scanner-detection --}}
<script src="{{ asset('admin/vendors/onscanjs/onscan.js') }}"></script>
{{-- Print JS --}}
<script src="{{ asset('admin/vendors/print/print.min.js') }}"></script>
{{-- Barcode JS --}}
<script src="{{ asset('admin/vendors/BarcodeJS/JsBarcode.all.min.js') }}"></script>
{{-- XLSX Xử lý excel --}}
<script src="{{ asset('admin/vendors/xlsx/xlsx.full.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/eruda"></script>
<script>
    eruda.init();
</script> --}}
<script>
    let config = {
        routes: {
            login: "{{ route('login.auth') }}",
            storage: "{{ asset(env('FILE_STORAGE', '/storage')) }}",
            placeholder: "{{ asset('admin/images/placeholder_key.png') }}",
            getImage: "{{ route('admin.image') }}",
            uploadImage: "{{ route('admin.image.upload') }}",
            updateImage: "{{ route('admin.image.update') }}",
            deleteImage: "{{ route('admin.image.delete') }}",
        },
        datatable: {
            lang: {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "_MENU_ dòng / trang",
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
            columns: {
                checkboxes: {
                    data: 'checkboxes',
                    name: 'checkboxes',
                    sortable: false,
                    searchable: false
                },
                id: {
                    data: 'id',
                    name: 'id'
                },
                code: {
                    data: 'code',
                    name: 'code',
                },
                order: {
                    data: 'order',
                    name: 'order',
                },
                sort: {
                    data: 'sort',
                    name: 'sort',
                    searchable: false,
                },
                avatar: {
                    data: 'avatar',
                    name: 'avatar',
                    sortable: false,
                    searchable: false,
                },
                quantity: {
                    data: 'quantity',
                    name: 'quantity',
                    searchable: false,
                },
                price: {
                    data: 'price',
                    name: 'price',
                    className: 'text-end',
                },
                name: {
                    data: 'name',
                    name: 'name',
                },
                customer: {
                    data: 'customer',
                    name: 'customer'
                },
                note: {
                    data: 'note',
                    name: 'note'
                },
                status: {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                    searchable: false,
                },
                created_at: {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return (type == 'display') ? ((data != null) ? moment(data).format("DD/MM/YYYY H:mm") :
                            '') : data;
                    }
                },
                action: {
                    data: 'action',
                    name: 'action',
                    className: 'text-end',
                    sortable: false,
                    searchable: false
                },
            },
            columnDefines: [{
                    target: 0,
                    sortable: false,
                    searchable: false
                },
                {
                    target: $("#data-table thead tr th").length - 1,
                    sortable: false,
                    searchable: false,
                },
            ],
            pageLength: 20,
            lengths: [
                [5, 10, 20, 50, 100, 500],
                [5, 10, 20, 50, 100, 500],
            ],
        },
        sweetAlert: {
            confirm: {
                title: "Lưu ý!",
                text: "Hãy xác nhận trước khi tiếp tục?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "var(--bs-danger)",
                cancelButtonColor: "var(--bs-primary)",
                confirmButtonText: "Xác nhận",
                cancelButtonText: "Quay lại",
                reverseButtons: false
            },
            delay: {
                title: "Vẫn đang hoạt động...",
                text: "Thao tác của bạn cần nhiều thời gian hơn để xử lý. Xin hãy kiên nhẫn!",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            },
        },
        select2: {
            ajax: {
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: false
                        }
                    }
                },
                cache: 1000,
                delay: 300,
            },
            language: "vi",
            theme: "bootstrap-5",
            width: '100%',
            allowClear: false,
            closeOnSelect: true,
            scrollOnSelect: false,
        }
    }
    /**
     * PROFILE
     */
    $('.btn-change-branch').on('click', function() {
        Swal.fire({
            title: 'Chọn chi nhánh',
            html: `
                <select id="main_branch" class="form-select" name="main_branch">
                    @foreach (Auth::user()->branches as $branch)
                        <option value="{{ $branch->id }}"{{ Auth::user()->main_branch == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: 'Lưu',
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi AJAX request để lưu dữ liệu
                $.ajax({
                    url: "{{ route('admin.profile.change_branch') }}",
                    type: 'POST',
                    data: {
                        main_branch: $('[name=main_branch]').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        pushToastify(response.msg, response.status)
                        $('nav.navbar .user-name small').text(response.main_branch)
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Đã có lỗi xảy ra',
                            text: 'Xin hãy thử lại.',
                        });
                    }
                });
            }
        });
    });


    /**
     * USER PROCESS
     */
    $(document).on('click', '.btn-create-user', function(e) {
        e.preventDefault();
        const form = $('#user-form')
        resetForm(form)
        if ($(this).attr('data-phone')) {
            form.find('[name=phone]').val($(this).attr('data-phone'))
        }
        if ($(this).attr('data-email')) {
            form.find('[name=email]').val($(this).attr('data-email'))
        }
        if ($(this).attr('data-name')) {
            form.find('[name=name]').val($(this).attr('data-name'))
        }
        form.find('[name=status]').prop('checked', true);
        form.attr('action', `{{ route('admin.user.create') }}`)
        form.find('.modal').modal('show').find('.modal-title').text('Tài khoản mới')
    })

    $(document).on('click', '.btn-update-user', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id'),
            form = $('#user-form');
        resetForm(form);
        $.get(`{{ route('admin.user') }}/${id}`, function(user) {
            form.find('[name=id]').val(user.id)
            form.find('[name=name]').val(user.name)
            form.find('[name=phone]').val(user.phone)
            form.find('[name=email]').val(user.email)
            form.find('[name=birthday]').val(user.birthday)
            form.find('[name=address]').val(user.address)
            form.find(`[name=gender][value="${user.gender}"]`).prop('checked', true);
            form.find(`[name='status']`).prop('checked', user.status)
            form.attr('action', `{{ route('admin.user.update') }}`)
            form.find('[name=password]').removeAttr('required')
            form.find('.modal').modal('show').find('.modal-title').text(user.name)
            if (user.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            $('#user-avatar-preview').attr('src', user.avatarUrl)
        })
    })

    $(document).on('click', '.select-avatar', function(e) {
        e.preventDefault();
        $(this).parent().find('input[type="file"]').click();
    })

    $(document).on('change', '#user-avatar', function(e) {
        e.preventDefault();
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#user-avatar-preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        }
    })

    $(document).on('click', '.btn-update-user_role', function() {
        const id = $(this).attr('data-id'),
            form = $('#user_role-form');
        resetForm(form)
        $.get(`{{ route('admin.user') }}/${id}`).done(function(user) {
            form.attr('action', `{{ route('admin.user.update.role') }}`);
            form.find('#user_role-modal-label').text('Thiết lập vai trò cho ' + user.name)
            $.each(user.roles, function(i, role) {
                $('input[name="role_id[]"][value="' + role.id + '"]').prop('checked', true);
            });
            $.each(user.branches, function(i, branch) {
                $('input[name="branch_id[]"][value="' + branch.id + '"]').prop('checked', true);
            });
            $.each(user.warehouses, function(i, warehouse) {
                $('input[name="warehouse_id[]"][value="' + warehouse.id + '"]').prop('checked',
                    true);
            });

            if (user.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            form.find(`[name='id']`).val(id)
            form.find('.modal').modal('show')
        })
    })

    $(document).on('click', '.btn-update-user_password', function() {
        const id = $(this).attr('data-id'),
            form = $('#user_password-form');
        resetForm(form)
        form.attr('action', `{{ route('admin.user.update.password') }}`)
        form.find(`[name='id']`).val(id)
        form.find('.modal').modal('show')
    })
    //End User

    /**
     * CATALOGUE PROCESS
     */
    $(document).on('click', '.btn-create-catalogue', function(e) {
        e.preventDefault();
        const form = $('#catalogue-form')
        resetForm(form)
        form.addClass($(this).hasClass('btn-single') ? 'single' : '')
        form.find(`[name='status']`).prop('checked', true)
        form.attr('action', `{{ route('admin.catalogue.create') }}`)
        form.find('.modal').modal('show').find('.modal-title').text('Danh mục mới')
    })

    $('.btn-refresh-catalogue').click(function() {
        const btn = $(this)
        $.get(`{{ route('admin.catalogue') }}/tree`, function(html) {
            btn.parents('form').find('.catalogue-select .list-group').html(html);
        })
    })

    $(document).on('click', '.btn-update-catalogue', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id'),
            form = $('#catalogue-form');
        resetForm(form)
        $.get(`{{ route('admin.catalogue') }}/${id}`, function(catalogue) {
            form.find('[name=id]').val(catalogue.id)
            form.find('[name=name]').val(catalogue.name)
            form.find('[name=note]').val(catalogue.note)
            form.find('[name=avatar]').val(catalogue.avatar).change()
            if (catalogue.parent_id != null) {
                var option = new Option(catalogue._parent.name, catalogue._parent.id, true, true);
                form.find('[name=parent_id]').append(option).trigger({
                    type: 'select2:select'
                });
            } else {
                form.find('[name=parent_id]').val(null).trigger("change")
            }
            form.find('[name=status]').prop('checked', catalogue.status)
            form.attr('action', `{{ route('admin.catalogue.update') }}`)
            if (catalogue.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            form.find('.modal').modal('show').find('.modal-title').text(catalogue.name)
        })
    })
    // =========== END CATALOGUE ===========
</script>
<script src="{{ asset('admin/js/main.js') }}?v=2.0.2"></script>
@stack('quick_images')
@stack('scripts')

</html>
