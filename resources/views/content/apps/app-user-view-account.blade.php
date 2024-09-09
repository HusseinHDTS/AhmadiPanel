@extends('layouts/layoutMaster')

@section('title', 'نمایش کاربر - حساب کاربری')

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
    {{-- @vite(['resources/assets/js/app-admin-edit.js',]) --}}
    {{-- 'resources/assets/js/app-user-view.js', 'resources/assets/js/app-user-view-account.js' --}}
@endsection

@section('content')
    <script>
        window.adminId = {{ $admin->id }};
    </script>
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">مشاهده کاربر/</span>
        حساب کاربری
    </h4>
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ asset('assets/img/avatars/0.jpg') }}"
                                height="100" width="100" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $admin->name }}</h4>
                                <span
                                    class="badge bg-label-secondary mt-1">{{ $admin->roles[0]['name'] == 'admin' ? 'ادمین' : 'فروشنده' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-medium me-1">نام کاربری:</span>
                                <span>{{ $admin->name }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">ایمیل:</span>
                                <span>{{ $admin->email }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">وضعیت:</span>
                                <span class="badge bg-label-success">فعال</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">نقش:</span>
                                <span>{{ $admin->roles[0]['name'] == 'admin' ? 'ادمین' : 'فروشنده' }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            {{-- <a class="btn btn-primary me-3" data-bs-target="#editUser" data-bs-toggle="modal"
                                href="javascript:">ویرایش</a> --}}
                            @if (Auth::user()->id != $admin->id)
                                <a class="btn btn-label-danger suspend-user" href="javascript:">حذف</a>
                            @endif
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
                        <div class="col-md-12 col-12">
                            <label for="password" class="mb-2">پسورد جدید</label>
                            <input id="password" name="password" class="form-control" minLength="6">
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
