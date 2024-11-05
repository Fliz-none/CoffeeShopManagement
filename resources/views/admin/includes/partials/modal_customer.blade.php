<form class="save-form" id="customer-form" method="post">
    @csrf
    <div class="modal fade" id="customer-modal" aria-labelledby="customer-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="customer-modal-label">Chi tiết khách hàng</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 col-md-3 d-flex align-items-center">
                            <label class="form-label text-primary mb-0" for="customer-name">Tên khách hàng</label>
                        </div>
                        <div class="col-12 col-md-9 d-flex align-items-center">
                            <input class="form-control" id="customer-name" name="name" type="text" placeholder="Nhập tên khách hàng" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-3 d-flex align-items-center">
                            <label class="form-label text-primary mb-0" for="customer-phone">Số điện thoại</label>
                        </div>
                        <div class="col-12 col-md-9 d-flex align-items-center">
                            <input class="form-control" id="customer-phone" name="phone" type="text" placeholder="Nhập số điện thoại" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-3 d-flex align-items-center">
                            <label class="form-label text-primary mb-0" for="customer-level">Cấp độ</label>
                        </div>
                        <div class="col-12 col-md-9 d-flex align-items-center">
                            <select class="form-control" id="customer-level" name="level">
                                <option value="bronze">Bronze</option>
                                <option value="silver">Silver</option>
                                <option value="gold">Gold</option>
                                <option value="platinum">Platinum</option>
                            </select>
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
