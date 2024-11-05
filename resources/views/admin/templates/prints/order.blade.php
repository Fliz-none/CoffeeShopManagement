<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pha chế - {{ config('app.name', 'Store Butler') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('admin/vendors/print/print.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/key.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/work.css') }}" rel="stylesheet">
    <link type="image/x-icon" href="{{ Auth::user()->company->favicon_url ?? asset('admin/images/placeholder_key.png') }}" rel="shortcut icon">

    <style>
        * {
            font-weight: bold !important;
            color: black !important;
        }
    </style>

</head>

<body>
    <div id="print-container" style="font-size: 75%; color: #000000">
        <div class="container-fluid print-template">
            <div class="row">
                <div class="col-4">
                    <img class="img-fluid" src="{{ Auth::user()->company->logo_square_bw_url }}" />
                </div>
                <div class="col-8">
                    <h6 class="text-uppercase mb-0">{{ Auth::user()->company->name }}</h6>
                    <small class="mb-0">
                        Điện thoại: {{ optional(Auth::user()->company)->phone }}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h6 class="text-center mb-0 py-3">HÓA ĐƠN {{ $order->code }}</h6>
                </div>
                <div class="col-6"><small>Người bán: </small></div>
                <div class="col-6 text-end"><small>{{ $order->dealer->name }}</small></div>
                <div class="col-6"><small>Ngày bán:</small></div>
                <div class="col-6 text-end"><small>{{ $order->created_at->format('d/m/Y H:i') }}</small></div>
            </div>
            <div class="row pt-3 mt-3" style="border-top: 1px solid #000;">
                @php
                    $details = $order->details
                @endphp
                @foreach ($details as $i => $detail)
                    <div class="col-6 fw-bold {{ $i ? 'mt-2' : '' }} d-flex">
                        {{ $detail->product->name}}
                        <br /><small>{{ $detail->note ?? '' }}</small>
                        <br /><small>{{ $detail->price > $detail->product->price ? 'Phụ thu: ' . number_format(($detail->price - $detail->product->price) * $detail->quantity). 'đ' : ''}}</small>
                        <br /><small>{{ $detail->price < $detail->product->price ? 'Giảm giá: ' . number_format(($detail->product->price - $detail->price) * $detail->quantity). 'đ' : ''}}</small>
                    </div>
                    <div class="col-6 fs-6 text-end">
                        <small>{{ $detail->quantity }} &times; {{ number_format($detail->price) . 'đ' }}</small>
                    </div>
                @endforeach
            </div>
            <div class="row pt-3 mt-3" style="border-top: 1px solid #000;">
                <div class="col-7 mb-3 fw-bold">
                    TỔNG TIỀN {{ $details->sum('quantity') }} MÓN
                </div>
                <div class="col-5 mb-3 text-end fw-bold">
                    {{ number_format($order->details->sum('price')) }}đ
                </div>
                @if ($order->additions)
                    <div class="col-7 fw-bold">
                        SAU PHỤ THU - GIẢM GIÁ
                    </div>
                    <div class="col-5 mb-3 text-end fw-bold">
                        @if($order->totalAdditions > 0)
                        +
                        @endif
                         {{  number_format($order->totalAdditions) }}đ
                    </div>
                @endif
                <div class="col-7 mb-3 fs-5 fw-bold">
                    PHẢI THANH TOÁN
                </div>
                <div class="col-5 mb-3 fw-bold text-end fs-5 fw-bold">
                    {{ number_format($order->total) }}đ
                </div>
                {{-- @if ($order->transactions->count())
                    <div class="col-7 fw-bold">
                        ĐÃ THANH TOÁN
                    </div>
                    <div class="col-5 fw-bold text-end">
                        {{ number_format($order->paid) }}đ
                    </div>
                @endif --}}
            </div>
        </div>
        @if ($order->note)
            <div class="row m-4 p-3" style="opacity: 1; border-radius:.5rem; border: 1px solid #000000">
                <div class="col-12">
                    {{ $order->note }}
                </div>
            </div>
        @endif
        {{-- @if ($order->transactions->count() && $order->transactions->first()->payment >= 2)
            <div class="row mt-3 justify-content-center">
                <div class="col-12 text-center">
                    Quét mã thanh toán bên dưới bằng ứng dụng ngân hàng. <br>
                    @php
                        $bank_info = json_decode(cache()->get('settings')['bank_info']);
                        $index = $order->transactions->first()->payment - 2;
                        $src = 'https://img.vietqr.io/image/' . $bank_info[$index]->bank_id . '-' . $bank_info[$index]->bank_number . '-qr_only.png?amount=' . $order->total . '&addInfo=Thanh%20toan%20' . $order->code;
                    @endphp
                </div>
                <div class="col-4 text-center">
                    <img class="my-3 img-fluid" src="{{ $src }}" alt="QR thanh toán">
                </div>
                <ul class="col-12 text-center">
                    <li>Tài khoản số: {{ $bank_info[$index]->bank_number }}</li>
                    <li>Tại ngân hàng: {{ $bank_info[$index]->bank_name }}</li>
                    <li>Nội dung: Thanh toán <strong>{{ $order->code }}</strong></li>
                </ul>
            </div>
        @endif --}}
        <div class="row mt-3">
            <div class="col-12 text-center">CẢM ƠN QUÝ KHÁCH VÀ HẸN GẶP LẠI<br />HOTLINE: {{ Auth::user()->company->phone }}<br /><small>Vui lòng kiểm tra hóa đơn trước khi thanh toán</small></div>
        </div>
    </div>
</body>

</html>
