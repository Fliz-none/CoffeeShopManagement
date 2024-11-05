<form class="save-form" id="table-form" method="post">
    @csrf
    <div class="modal fade" id="table-modal" aria-labelledby="table-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="table-modal-label">Chi tiết bàn</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 col-md-3 d-flex align-items-center">
                            <label class="form-label text-primary mb-0" for="table-name">Tên bàn</label>
                        </div>
                        <div class="col-12 col-md-9 d-flex align-items-center">
                            <input class="form-control" id="table-name" name="name" type="text"
                                placeholder="Nhập tên bàn" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-3 d-flex align-items-center">
                            <label class="form-label text-primary mb-0" for="table-note">Ghi chú</label>
                        </div>
                        <div class="col-12 col-md-9 d-flex align-items-center">
                            <input class="form-control" id="table-note" name="note" type="text"
                                placeholder="Nhập ghi chú" autocomplete="off">
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="text-end">
                        <input name="id" type="hidden">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
