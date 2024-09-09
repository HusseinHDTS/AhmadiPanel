@extends('layouts/layoutMaster')

@section('title', 'ویرایش کانفیگ')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
    @vite(['resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
    @vite(['resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/swiper/swiper.js'])
    @vite(['resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-config-edit.js')
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('content')

    <div class="col-xl-12 mb-4 col-lg-12 col-12">
        <div class="card">
            <form action="/app/config/{{ $config->id }}" method="POST">
                @csrf
                <div class="row card-body mb-2">
                    <div class="col-md-6 col-12 mb-3">
                        <label for="title">عنوان</label>
                        <input name="title" class="form-control" value="{{ $config->title }}" />
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="config">کانفیگ</label>
                        <textarea name="config" class="form-control">{{ $config->config }}</textarea>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="assigned_to">کاربر</label>
                        <select class="form-control user-list-select" name="assigned_to">
                        <option value="">همه</option>
                            @if ($config->user)
                                <option value="{{ $config->user->id }}">{{ $config->user->username }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="internet_type">نوع خط</label>
                        <select class="form-select" name="internet_type">
                            <option value="irancel" @if ($config->internet_type == 'irancel') selected @endif>ایرانسل</option>
                            <option value="hamrah" @if ($config->internet_type == 'hamrah') selected @endif>همراه اول</option>
                            <option value="rightel" @if ($config->internet_type == 'rightel') selected @endif>رایتل</option>
                            <option value="wifi" @if ($config->internet_type == 'wifi') selected @endif>وای‌فای</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="active">وضعیت</label>
                        <select class="form-select" name="active">
                            <option value="true" @if ($config->active == 'true') selected @endif>فعال</option>
                            <option value="false" @if ($config->active == 'false') selected @endif>غیرفعال</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="active">اولویت</label>
                        <input class="form-control" type="number" name="order" value="{{ $config->order }}">
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
