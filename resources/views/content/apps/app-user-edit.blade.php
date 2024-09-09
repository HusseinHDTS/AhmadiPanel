@extends('layouts/layoutMaster')

@section('title', 'ویرایش کاربر - حساب کاربری')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @vite(['resources/assets/vendor/libs/spinkit/spinkit.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-user-view.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
    @vite(['resources/assets/vendor/libs/block-ui/block-ui.js'])
@endsection

@section('page-script')
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">مشاهده کاربر/</span>
        حساب کاربری
    </h4>
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('assets/img/avatars/0.jpg') }}"
                                height="100" width="100" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $user->username }}</h4>
                                <span
                                    class="badge bg-label-secondary mt-1">{{ $user->status == 'active' ? 'فعال' : 'غیرفعال' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-medium me-1">نام کاربری:</span>
                                <span>{{ $user->username }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">پسورد:</span>
                                <span>{{ $user->password }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">تعداد دستگاه های فعال:</span>
                                <span>{{ $user->active_sessions }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">تعداد دستگاه های مجاز:</span>
                                <span>{{ $user->max_active_session }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">اشتراک:</span>
                                <span>{{ $user->sub_days }} روزه</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-label-danger suspend-user" href="/app/user/list/{{$user->id}}/delete">حذف</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                            class="ti ti-user-check ti-xs me-1"></i>حساب کاربری</a></li>
            </ul>
            <div class="card mb-4">
                <form class="m-3" id="editAdminForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <label for="username" class="mb-2">نام کاربری</label>
                            <input id="username" name="username" class="form-control" minLength="1" value="{{$user->username}}">
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <label for="password" class="mb-2">پسورد</label>
                            <input id="password" name="password" class="form-control" minLength="2" value="{{$user->password}}">
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <label for="user-internet-type" class="mb-2">نوع خط</label>
                            <select id="user-internet-type" class="form-select" name="internet_type">
                                <option value="irancel" @if($user->internet_type == "irancel") selected @endif>ایرانسل</option>
                                <option value="hamrah" @if($user->internet_type == "hamrah") selected @endif>همراه اول</option>
                                <option value="rightel" @if($user->internet_type == "rightel") selected @endif>رایتل</option>
                                <option value="wifi" @if($user->internet_type == "wifi") selected @endif>وای‌فای</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <label for="max_active_session" class="mb-2">تعداد دستگاه های مجاز</label>
                            <input id="max_active_session" type="number" name="max_active_session" class="form-control" minLength="1" value="{{$user->max_active_session}}">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="sub_days" class="mb-2">اعتبار (روز)</label>
                            <input id="sub_days" type="number" name="sub_days" class="form-control" minLength="1" value="{{$user->sub_days}}">
                        </div>
                        <div class="col-12 mb-2">
                            <div class="bg-warning px-2 py-1 border text-white">
                            <p>با تغییر روز اعتبار، اشتراک به صورت خودکار تمدید میشود</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <button class="btn btn-primary col-12">ثبت</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-edit-user')
@endsection
