<form class="save-form" id="role-form" method="post">
    @csrf
    <div class="modal fade text-left" id="role-modal" role="dialog" aria-labelledby="role-modal-label">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header key-bg-primary">
                    <h4 class="modal-title white">Chi tiết vai trò</h4>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="col-form-label text-md-end" data-bs-toggle="tooltip" data-bs-title="Tên dùng để xác định quyền hạn và trách nhiệm của người dùng trong hệ thống" for="role-name">Tên vai trò</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" id="role-name" name="name" type="text" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $permissions = cache()->get('spatie.permission.cache')['permissions'];
                        @endphp
                        @foreach ($permissions as $index => $permission)
                            @php
                                $company_array = Auth::user()->company->toArray();
                            @endphp
                            @if ($permission['e'] == 1 || isset($company_array[$permission['e']]))
                                @if ($index == 0 || $permission['d'] != $permissions[$index - 1]['d'])
                                    <div class="col-12 col-lg-4 col-md-6 mb-4 permission-section">
                                        <fieldset>
                                            <div class="d-flex">
                                                <div class="form-check form-switch d-flex align-items-center">
                                                    <input class="form-check-input permissions h6 me-3" id="permissions-{{ $index }}" type="checkbox" role="switch">
                                                </div>
                                                <legend>
                                                    <label class="form-check-label" for="permissions-{{ $index }}">{{ $permission['d'] }}</label>
                                                </legend>
                                            </div>
                                @endif
                                <div class="form-check form-switch">
                                    <input class="form-check-input permission" id="permission-{{ $permission['a'] }}" name="permissions[]" type="checkbox" value="{{ $permission['a'] }}" role="switch">
                                    <label class="form-check-label" for="permission-{{ $permission['a'] }}">{{ $permission['b'] }}</label>
                                </div>
                                @if ($index == count($permissions) - 1 || $permission['d'] != $permissions[$index + 1]['d'])
                                    </fieldset>
                    </div>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <input name="id" type="hidden" value="">
                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ROLE, App\Models\User::CREATE_ROLE)))
                    <input name="id" type="hidden">
                    <button class="btn btn-primary" id="role-submit" type="submit">Lưu</button>
                @endif
            </div>
        </div>
    </div>
    </div>
</form>
