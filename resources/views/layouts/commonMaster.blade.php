<!DOCTYPE html>
@php
    $menuFixed = $configData['layout'] === 'vertical' ? $menuFixed ?? '' : ($configData['layout'] === 'front' ? '' : $configData['headerType']);
    $navbarType = $configData['layout'] === 'vertical' ? $configData['navbarType'] ?? '' : ($configData['layout'] === 'front' ? 'layout-navbar-fixed' : '');
    $isFront = ($isFront ?? '') == true ? 'Front' : '';
    $contentLayout = isset($container) ? ($container === 'container-xxl' ? 'layout-compact' : 'layout-wide') : '';
@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
    class="{{ $configData['style'] }}-style {{ $contentLayout ?? '' }} {{ $navbarType ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $menuFlipped ?? '' }} {{ $menuOffcanvas ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
    dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}"
    data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{ url('/') }}" data-framework="laravel"
    data-template="{{ $configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['styleOpt'] }}">

<head>
    <meta charset="utf-8" />
    {{-- @laravelPwaMeta --}}
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') |
        {{ config('variables.templateName') ? config('variables.templateName') : 'TemplateName' }} -
        {{ config('variables.templateSuffix') ? config('variables.templateSuffix') : 'TemplateSuffix' }}
    </title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />



    <!-- Include Styles -->
    <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/styles' . $isFront)

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/scriptsIncludes' . $isFront)
    @vite(['resources/assets/vendor/libs/toastr/toastr.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])
    @vite(['resources/assets/vendor/libs/toastr/toastr.js'])

</head>

<body>
    @if (Auth::user())
        <script>
            window.apiToken = "{{ Auth::user()->api_token }}";
            window.loggedInRole = "{{ Auth::user()->hasRole('admin') ? 'admin' : 'user' }}";
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            toastr.options = {
                maxOpened: 1,
                autoDismiss: true,
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                positionClass: 'toast-top-left',
                preventDuplicates: true,
                onclick: null,
                rtl: false
            };
        })
    </script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                toastr.success("{{ session('success') }}");
            })
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                toastr.error("{{ session('error') }}");
            })
        </script>
    @endif

    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->



    <!-- Include Scripts -->
    <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
    {{-- @laravelPwaScript --}}
    @include('layouts/sections/scripts' . $isFront)

</body>

</html>
