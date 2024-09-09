@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
    $configData = Helper::appClasses();

    /* Display elements */
    $customizerHidden = $customizerHidden ?? '';

@endphp

@extends('layouts/commonMaster')

@section('layoutContent')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .centered-div {
            width: 100%;
            height: 200px;
            /* display: flex; */
            text-align: center;
            justify-content: center;
            align-items: center;
        }
    </style>
    <!-- Content -->
    <div class="centered-div">
        <h6>419</h6>
        <h3>
            صفحه منقضی شده است
        </h3>
        <a class="btn btn-primary btn-next" href="{{url("/")}}">
            <span class="align-middle d-sm-inline-block d-none me-sm-1">بازگشت به داشبورد</span>
            <i class="ti ti-dashboard"></i>
        </a>
    </div>
    <!--/ Content -->
@endsection
