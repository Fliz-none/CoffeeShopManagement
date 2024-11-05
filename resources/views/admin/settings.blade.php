@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-6 order-md-1 order-last">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                </div>
                <div class="col-12 col-md-4 col-lg-6 order-md-2 order-first">
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @if (session('response') && session('response')['status'] == 'success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check"></i>
            {!! session('response')['msg'] !!}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @elseif (session('response'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-xmark"></i>
            {!! session('response')['msg'] !!}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @endif
    @if (!empty(Auth::user()->can(App\Models\User::ACCESS_SETTING)))
        <div class="page-content mb-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <ul class="nav nav-pills mb-3">
                        <li class="nav-item">
                            <a class="nav-link{!! Request::path() === 'quantri/setting/general' ? ' active" aria-current="page' : '' !!}" href="{{ route('admin.setting', ['key' => 'general']) }}">
                                Cài đặt hệ thống
                            </a>
                        </li>
                    </ul>
                    @include('admin.includes.setting_general')
                </div>
            </div>
        </div>
    @else
        @include('admin.includes.access_denied')
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.btn-remove-bank-account', function() {
                if ($('.bank-accounts').children().length > 1) {
                    $('.bank-accounts').children().last().remove();
                } else {
                    pushToastify('Phải có ít nhất một tài khoản', 'danger')
                }
            })
            $(document).on('click', '.btn-add-bank-account', function() {
                let number_accounts = $('.bank-accounts').children().length;
                let str = `<div class="bank-account"><hr>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label" for="bank_id-${number_accounts}">Ngân hàng<br />
                                        <small class="form-text text-muted" id="bank_id-help-${number_accounts}"> Dùng xuất mã QR thanh toán theo đơn hàng</small>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="d-none bank-names-hidden"></div>
                                        <select name="bank_ids[${number_accounts}]" id="bank_id-${number_accounts}" class="bank-selected form-select @error('bank_ids.${number_accounts}') is-invalid @enderror"> <option selected disabled hidden>Vui lòng chọn một ngân hàng</option> @foreach ($banks['data'] as $bank)     @if ($bank['transferSupported'] == 1)         <option data-bank_name="{{ $bank['short_name'] }}" value="{{ $bank['bin'] }}">             {{ $bank['short_name'] }} - {{ $bank['name'] }}         </option>     @endif @endforeach
                                        </select>
                                        @error('bank_ids.${number_accounts}') <span class="invalid-feedback d-block" role="alert">     <strong>{{ $message }}</strong> </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label" for="bank_account-${number_accounts}">Tên tài khoản<br />
                                        <small class="form-text text-muted" id="bank_account-help-${number_accounts}">Dùng xuất mã QR thanh toán theo đơn hàng</small>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control @error('bank_accounts.${number_accounts}') is-invalid @enderror" id="bank_account-${number_accounts}" name="bank_accounts[${number_accounts}]" type="text">
                                        @error('bank_accounts.${number_accounts}') <span class="invalid-feedback d-block" role="alert">     <strong>{{ $message }}</strong> </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label" for="bank_number-${number_accounts}">Số tài khoản<br />
                                        <small class="form-text text-muted" id="bank_number-help-${number_accounts}">Dùng xuất mã QR thanh toán theo đơn hàng</small>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control @error('bank_numbers.${number_accounts}') is-invalid @enderror" id="bank_number-${number_accounts}" name="bank_numbers[${number_accounts}]" type="text">
                                        @error('bank_numbers.${number_accounts}') <span class="invalid-feedback d-block" role="alert">     <strong>{{ $message }}</strong> </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>`;
                $('.bank-accounts').append(str);
            });

            $(document).on('change', '.bank-selected', function() {
                const bankNameSelected = $(this).find('option:selected').attr('data-bank_name');
                console.log(bankNameSelected);
                $(this).parent().find('.bank-names-hidden').html(`<input type="hidden" name="bank_names[]" value="${bankNameSelected}">`)
            })
        })
    </script>
@endpush
