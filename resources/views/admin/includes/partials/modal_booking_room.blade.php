<form class="save-form" id="booking-room-form" method="post">
    @csrf
    <div class="modal fade" id="booking-room-modal" aria-labelledby="booking-room-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-full"> <!-- Larger modal for detailed information -->
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="booking-room-modal-label">Đặt phòng</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Room List -->
                    <div class="row px-5">
                        <div class="col-12">
                            <div class="rooms-swiper">
                                <div class="swiper-wrapper rooms-wrapper px-2">
                                    <!-- Room slides included here -->
                                    @include('admin.includes.partials.rooms')
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Details Section -->
                    <div class="border p-3 mb-3" id="booking-room-details" style="display: none;">
                        <h5 class="text-info">Thông tin chi tiết phòng</h5>
                        <p><strong>Tên phòng:</strong> <span id="booking-room-name"></span></p>
                        <p><strong>Ghi chú:</strong> <span id="booking-room-note-detail"></span></p>
                        <p><strong>Thời gian bắt đầu:</strong> <span id="booking-room-start-time"></span></p>
                        <p><strong>Thời gian kết thúc:</strong> <span id="booking-room-end-time"></span></p>
                        <p><strong>Trạng thái:</strong> <span id="booking-room-status"></span></p>
                    </div>

                    <!-- Room Booking Information -->
                    <div class="row mb-3">
                        <div class="col-12 form-group">
                            <label class="form-label text-primary" for="booking-room-note">Ghi chú</label>
                            <input class="form-control" id="booking-room-note" name="note" type="text" placeholder="Nhập ghi chú" autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Start Time -->
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label text-primary" for="start-time">Thời gian bắt đầu</label>
                            <input class="form-control" id="start-time" name="start_time" type="datetime-local">
                        </div>

                        <!-- End Time -->
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label text-primary" for="end-time">Thời gian kết thúc</label>
                            <input class="form-control" id="end-time" name="end_time" type="datetime-local">
                        </div>
                    </div>

                    <hr class="px-5">
                    <div class="text-end">
                        <input name="id" type="hidden">
                        <button class="btn btn-primary" type="submit">Đặt phòng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .rooms-swiper {
        width: 90%;
        margin: 0 auto;
    }
</style>
