<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>Hookah</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('css/admin.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
        @yield('styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
                @include('components.admin-sidebar')
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @include('components.admin-header')
                    <div class="content d-flex flex-column flex-column-fluid fs-6 pt-2" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/plugins.bundle.js') }}"></script>
        <script src="{{ asset('js/scripts.bundle.js') }}"></script>
        @yield('scripts')
        <script src="{{ asset('js/admin.js') }}"></script>
    </body>
</html>