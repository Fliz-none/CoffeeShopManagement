<form method="post" id="update-work-form" class="save-form">
    <div class="modal fade" id="update-work-modal" tabindex="-1" aria-labelledby="update-work-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 me-2" id="update-work-modal-label">Cập nhật chấm công</h1>
                    <h1 class="fs-4 update-workday"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mx-3">
                        <div class="update-work-time">
                            <div class="row justify-content-center align-item-center align-items-center">
                                <div class="col-3 fw-bold">Tên nhân viên</div>
                                <div class="col-3 fw-bold">Ngày giờ</div>
                                <div class="col-6 fw-bold mb-3 text-center">Chấm công</div>
                                <div class="col-3 work-employee"></div>
                                <div class="col-3 work-date"></div>
                                <div class="col-6 work-attendance text-center"></div>
                            </div>
                            <input type="hidden" class="time-before">
                            <input type="hidden" class="duration">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id">
                    <input type="hidden" name="work_created_at">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form>
