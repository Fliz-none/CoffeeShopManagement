<form class="save-form" id="schedule-form" method="post">
    @csrf
    <div class="modal fade" id="schedule-modal" aria-labelledby="schedule-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="schedule-modal-label">Chi tiết lịch trình</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Chọn nhân viên -->
                    <div class="col-12 form-group mb-3">
                        <label class="form-label text-primary" for="schedule-user">Xếp lịch cho</label>
                        <select class="form-control" id="schedule-user" name="user_id">
                            <option value="">Chọn nhân viên</option>
                            @if (isset($users))
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Ngày làm việc -->
                    <div class="col-12 form-group mb-3">
                        <label class="form-label text-primary" for="schedule-date">Ngày làm việc</label>
                        <input class="form-control" id="schedule-date" name="date" type="date" autocomplete="off">
                    </div>

                    <!-- Số slot -->
                    <div class="col-12 form-group mb-3 ">
                        <label class="form-label text-primary" for="schedule-slot">Số Slot</label>
                        <input class="form-control" id="schedule-slot" name="slot" type="number" placeholder="Nhập số slot nhân viên làm trong ngày" autocomplete="off">
                    </div>

                    <!-- Khu vực hiển thị slot -->
                    <div id="slot-container" class="px-3 col-12"></div>

                    <hr class="px-5">
                    <div class="text-end">
                        <input type="hidden" name="slot_times" id="slot-times">
                        <input name="id" type="hidden">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Styles for Slot -->
<style>
    .slot-item {
        margin-bottom: 15px;
    }
    .slider-label {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
    .ui-slider-range{
        background-color: hsl(24, 49%, 50%) !important;
    }
</style>
