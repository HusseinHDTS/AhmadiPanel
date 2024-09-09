@extends('layouts/layoutMaster')

@section('title', 'داشبورد - تجارت الکترونیک')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.scss', 'resources/assets/vendor/libs/jquery-timepicker/jquery-timepicker.scss', 'resources/assets/vendor/libs/pickr/pickr-themes.scss'])
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
    @vite(['resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
    @vite(['resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/jdate/jdate.min.js', 'resources/assets/vendor/libs/flatpickr/flatpickr-jdate.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js', 'resources/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js', 'resources/assets/vendor/libs/pickr/pickr.js'])
    @vite(['resources/assets/vendor/libs/swiper/swiper.js'])
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
    @vite(['resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/flatpicker.fa.js', 'resources/assets/js/app-dashboard.js'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('content')

    <div class="col-xl-12 mb-4 col-lg-12 col-12">
        <h4>تنظیمات</h4>
        <div class="card">
            <form action="{{ route('app-settings-change.post') }}" method="POST">
                @csrf
                <div class="row card-body mb-2">
                    <h5 class="mb-3">تنظیمات نرم‌افزار</h5>
                    <div class="col-md-6 col-12">
                        <label for="info-text">متن اطلاع رسانی به کاربران</label>
                        @isset($settings->info)
                            <textarea id="info-text" name="info" class="form-control mt-2">{{ $settings->info }}</textarea>
                        @else
                            <textarea id="info-text" name="info" class="form-control mt-2"></textarea>
                        @endisset
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <label for="test-url">آدرس سایت تست سرعت</label>
                        <input id="test-url" name="test_url"
                            value="@isset($settings->test_url){{ $settings->test_url }}@endisset"
                            class="form-control mt-2">
                    </div>
                    <div class="mt-4 col-12 row">
                        <div class="col-md-3 col-6 mb-2">
                            <input class="form-check-input" type="checkbox" id="allowinsecure" name="allow_insecure" @if($settings->allow_insecure == 1) checked @endif>
                            <label class="form-check-label" for="allowinsecure">Allowlnsecure</label>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <input class="form-check-input" type="checkbox" id="enablemux" name="enable_mux" @if($settings->enable_mux == 1) checked @endif>
                            <label class="form-check-label" for="enablemux">EnableMux</label>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <input class="form-check-input" type="checkbox" id="EnableFragment" name="enable_fragment" @if($settings->enable_fragment == 1) checked @endif>
                            <label class="form-check-label" for="EnableFragment">EnableFragment</label>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <input class="form-check-input" type="checkbox" id="PreferIpv6" name="prefer_ipv6" @if($settings->prefer_ipv6 == 1) checked @endif>
                            <label class="form-check-label" for="PreferIpv6">PreferIpv6</label>
                        </div>
                    </div>
                    <hr class="my-5">
                    <h5>منو دلخواه</h5>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <label for="custom-menu-title">نام منو</label>
                        <input id="custom-menu-title" name="custom_menu_title"
                            value="@isset($settings->custom_menu_title){{ $settings->custom_menu_title }}@endisset"
                            class="form-control mt-2">
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <label for="custom-menu-link">لینک منو</label>
                        <input id="custom-menu-link" name="custom_menu_link"
                            value="@isset($settings->custom_menu_link){{ $settings->custom_menu_link }}@endisset"
                            class="form-control mt-2">
                    </div>
                    <hr class="my-5">
                    <h5>ورژن جدید</h5>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <label for="version-link">لینک دانلود</label>
                        <input id="version-link" name="version_link"
                            value="@isset($settings->version_link){{ $settings->version_link }}@endisset"
                            class="form-control mt-2">
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <label for="version">ورژن</label>
                        <input id="version" name="version"
                            value="@isset($settings->version){{ $settings->version }}@endisset"
                            class="form-control mt-2">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">ثبت</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Invoice table -->
@endsection
