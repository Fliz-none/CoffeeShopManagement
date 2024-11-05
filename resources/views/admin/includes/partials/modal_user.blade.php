<form class="save-form" id="user-form" method="post">
    @csrf
    <div class="modal fade" id="user-modal" data-bs-backdrop="static" aria-labelledby="user-modal-label">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="user-modal-label">Tài khoản</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="sticky-top">
                                <label class="form-label ratio ratio-1x1 select-avatar" for="user-avatar">
                                    <img class="img-fluid rounded-4 object-fit-cover" id="user-avatar-preview"
                                        src="{{ asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                </label>
                                <input class="d-none" id="user-avatar" name="avatar" type="file" multiple
                                    accept="image/*">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary btn-remove-image d-none"
                                        type="button">Xoá</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" for="user-name" data-bs-toggle="tooltip"
                                    data-bs-title="Tên thường gọi của người sử dụng tài khoản">Họ tên</label>
                                <input class="form-control" id="user-name" name="name" type="text"
                                    placeholder="Tên hiển thị" autocomplete="off" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" for="user-phone" data-bs-toggle="tooltip"
                                    data-bs-title="Điện thoại người sử dụng tài khoản">Điện thoại</label>
                                <input class="form-control" id="user-phone" name="phone" type="text"
                                    placeholder="Số điện thoại" autocomplete="off" inputmode="numeric">
                            </div>
                            <div class="pt-2 row align-items-center">
                                <div class="col-12 btn-group pb-3">
                                    <input class="btn-check" id="gender-male" name="gender" type="radio"
                                        value="0">
                                    <label class="btn btn-outline-primary" for="gender-male">Nam</label>
                                    <input class="btn-check" id="gender-female" name="gender" type="radio"
                                        value="1">
                                    <label class="btn btn-outline-primary" for="gender-female">Nữ</label>
                                    <input class="btn-check" id="gender-other" name="gender" type="radio"
                                        value="2">
                                    <label class="btn btn-outline-primary" for="gender-other">Khác</label>
                                </div>
                            </div>
                            <div class="collapse" id="user-more">
                                <div class="mb-3 form-group">
                                    <label class="form-label fw-bold" for="user-email" data-bs-toggle="tooltip"
                                        data-bs-title="Email dùng để đăng nhập vào hệ thống">Email</label>
                                    <input class="form-control" id="user-email" name="email" type="email"
                                        placeholder="Email người dùng" autocomplete="off" inputmode="email">
                                </div>
                                <div class="mb-3 form-group">
                                    <label class="col-form-label fw-bold" for="user-birthday"
                                        data-bs-toggle="tooltip"
                                        data-bs-title="Ngày sinh của người sử dụng tài khoản">Ngày sinh</label>
                                    <input class="form-control" id="user-birthday" name="birthday" type="date"
                                        max="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#user-more" aria-expanded="false" aria-controls="user-more">
                                Thêm thông tin
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="user-status" name="status" type="checkbox">
                                    <label class="form-check-label" for="user-status" data-bs-toggle="tooltip" data-bs-title="Trạng thái tài khoản có thể được thay đổi sau này">Hoạt động</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_USER, App\Models\User::CREATE_USER)))
                                    <input name="id" type="hidden">
                                    <button class="btn btn-primary" type="submit">Lưu</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form class="save-form" id="user_role-form" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="user_role-modal" aria-labelledby="user_role-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title fs-5 text-white" id="user_role-modal-label"></h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body overflow-auto row justify-content-center">
                        <div class="col-12 col-md-6">
                            <div class="form-group search-container">
                                <label class="form-label fw-bolder d-flex align-items-center mb-0" for="role-search-input" data-bs-toggle="tooltip" data-bs-title="Chọn chi vai trò của tài khoản">Vai trò</label>
                                <input class="form-control search-input" id="role-search-input" placeholder="Nhập từ khóa để tìm kiếm">
                            </div>
                            <div class="search-item overflow-auto h-100" id="roles-check">
                                <ul class="list-group search-list">
                                    @foreach (cache()->get('roles') as $id => $roleName)
                                        <li class="list-group-item border border-0 pb-0">
                                            <input type="checkbox" name="role_id[]" id="role-{{$id}}" class="form-check-input me-1" value="{{$id}}">
                                            <label class="form-check-label" for="role-{{$id}}">{{$roleName}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group search-container">
                                <label class="form-label fw-bolder d-flex align-items-center mb-0" for="branch-search-input" data-bs-toggle="tooltip" data-bs-title="Chọn chi nhánh quản lý nhân sự">Chi nhánh</label>
                                <input class="form-control search-input" id="branch-search-input" placeholder="Nhập từ khóa để tìm kiếm">
                            </div>
                            <div class="search-item overflow-auto h-100" id="branches-check">
                                <ul class="list-group search-list">
                                    @foreach (cache()->get('branches') as $branch)
                                        <li class="list-group-item border border-0 pb-0">
                                            <input type="checkbox" name="branch_id[]" id="branch-{{$branch->id}}" class="form-check-input me-1" value="{{$branch->id}}">
                                            <label class="form-check-label d-inline" for="branch-{{$branch->id}}">{{$branch->name}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr class="px-5">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                </div>
                                <div class="col-12 col-lg-6 text-end">
                                    {{-- @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_USER))) --}}
                                        <input name="id" type="hidden">
                                        <button class="btn btn-primary" type="submit">Lưu</button>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form class="save-form" id="user_password-form" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="user_password-modal" aria-labelledby="user_password-modal-label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title fs-5 text-white" id="user_password-modal-label">Đặt mật khẩu</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="user_password-password">Mật khẩu mới</label>
                            <input class="form-control" id="user_password-password" name="password" type="text">
                        </div>
                        <hr class="px-5">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                </div>
                                <div class="col-12 col-lg-6 text-end">
                                    @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_USER)))
                                        <input name="id" type="hidden">
                                        <button class="btn btn-primary" type="submit">Lưu</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
