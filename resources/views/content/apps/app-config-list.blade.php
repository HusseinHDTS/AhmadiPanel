@extends('layouts/layoutMaster')

@section('title', 'لیست کانفیگ‌ها')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @vite('resources/assets/vendor/libs/spinkit/spinkit.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/block-ui/block-ui.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-config-list.js')
@endsection

@section('content')

    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-configs table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>اولویت</th>
                        <th>عنوان</th>
                        <th>خط</th>
                        <th>کانفیگ عمومی</th>
                        <th>برای کاربر</th>
                        <th>متن کانفیگ</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="canvasAddCustomConfig"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">افزودن کانفیگ</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                <form class="add-new-config pt-0" id="addNewConfigForm"
                    method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="add-title">عنوان</label>
                        <input type="text" class="form-control" id="add-title" placeholder="عنوان" name="title"
                            aria-label="عنوان" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-config">کانفیگ</label>
                        <textarea id="add-config" name="config" class="form-control" placeholder="CustomConfig Or Uri"></textarea>
                    </div>
                    <div class="mb-3 bg-warning text-white px-3 py-2 text-center" style="border-radius: 4px">
                        <p>کانفیگ میتواند JSON و یا URI باشد</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user-assigned-to">کاربر</label>
                        <select id="user-assigned-to" class="form-select users-list-select"
                            style="z-index: 999999999999 !important;" name="assigned_to">
                            <option value="">همه کاربران</option>
                        </select>
                    </div>
                    <div class="mb-3 bg-warning text-white px-3 py-2 text-center" style="border-radius: 4px">
                        <p>درصورت انتخاب نکردن، کانفیگ برای همه نمایش داده میشود</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user-internet-type">نوع خط</label>
                        <select id="user-internet-type" class="form-select" name="internet_type">
                            <option value="irancel">ایرانسل</option>
                            <option value="hamrah">همراه اول</option>
                            <option value="rightel">رایتل</option>
                            <option value="wifi">وای‌فای</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user-status">وضعیت</label>
                        <select id="user-status" class="form-select" name="active">
                            <option value="true">فعال</option>
                            <option value="false">غیرفعال</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-order">اولویت</label>
                        <input id="add-order" class="form-control" placeholder="0" value="0" aria-label="اولویت"
                            type="number" name="order" />
                    </div>
                    <button type="button" class="btn btn-primary me-sm-3 me-1 data-submit">ارسال</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">لغو</button>
                </form>
            </div>
        </div>
    </div>

@endsection
