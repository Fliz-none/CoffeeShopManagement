
@foreach ($rooms as $room)
<div class="swiper-slide room-slide">
    <label for="room-select-{{ $room->id }}">
        <input class="d-none room-select" id="room-select-{{ $room->id }}" name="room_id" data-status="{{ $room->status }}" data-sort="{{ true }}" type="radio" value="{{ $room->id }}">
        <div class="card room-card rounded-4 rounded-lg-5 {{ $room->status ? 'room-busy' : 'room-free' }}" data-id="{{ $room->id }}">
            <span class="text-overlay">{{ $room->id }}</span>
            <div class="card-body">
                <h5 class="fs-6 text-uppercase">{{ $room->name }}</h5>
                <small>{!! $room->statusStr !!}</small>
                <small>{{ $room->note ? $room->note : '' }}</small>
            </div>
        </div>
        <div class="room-count {{ $room->count ? '' : 'd-none' }}" data-id="{{ $room->id }}">
            <button class="btn btn-success btn-lg rounded-pill" type="button">{{ $room->count }}</button>
        </div>
    </label>
    <div class="dropstart room-menu" data-id="{{ $room->id }}">
        <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu p-2">
            <li>
                <a class="cursor-pointer dropdown-item btn-update-room" data-id="{{ $room->id }}">
                    <small><i class="bi bi-pencil-square"></i> Sửa phòng</small>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider" />
            </li>
            <li>
                <form class="save-form" action="{{ route('admin.room.remove') }}" method="post">
                    @csrf
                    <input name="choices[]" type="hidden" value="{{ $room->id }}">
                    <button class="cursor-pointer text-danger dropdown-item btn-remove" type="submit">
                        <small><i class="bi bi-trash3"></i> Xóa phòng</small>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
@endforeach
