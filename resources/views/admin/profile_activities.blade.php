@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageName }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    @include('admin.includes.profile_beside')
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Hoạt động gần đây') }}</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">{{ __('Hành động') }}</th>
                                        <th>{{ __('Loại') }}</th>
                                        <th>{{ __('Thông tin địa lý') }}</th>
                                        <th>{{ __('Thiết bị') }}</th>
                                        <th>{{ __('Thời gian') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ ucfirst($log->action) }}</td>
                                            <td>{{ $log->type }}</td>
                                            <td>
                                                @php
                                                    $geoData = json_decode($log->geolocation, true);
                                                @endphp
                                                <ul>
                                                    <li>IP: {{ $geoData['ip'] ?? 'N/A' }}</li>
                                                    <li>Thành phố: {{ $geoData['city'] ?? 'N/A' }}</li>
                                                    <li>Vùng: {{ $geoData['region'] ?? 'N/A' }}</li>
                                                    <li>Quốc gia: {{ $geoData['country'] ?? 'N/A' }}</li>
                                                    <li>Vị trí: {{ $geoData['loc'] ?? 'N/A' }}</li>
                                                    <li>Tổ chức: {{ $geoData['org'] ?? 'N/A' }}</li>
                                                    <li>Mã bưu điện: {{ $geoData['postal'] ?? 'N/A' }}</li>
                                                    <li>Múi giờ: {{ $geoData['timezone'] ?? 'N/A' }}</li>
                                                </ul>
                                            </td>
                                            <td>{{ $log->device }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // Custom scripts here
    </script>
@endpush
