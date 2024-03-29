<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}" style="animation-duration: 0.3s;">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container"><div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
            <!--begin::Heading-->
            @php 
                $bradcrumb = ucfirst(preg_replace('@^.*\/([a-zA-z]*$)@', '$1', url()->current()));
                if($bradcrumb === 'Admin'){
                    $bradcrumb = 'Dashboard';
                }
            @endphp
            <h1 class="text-dark fw-bolder mt-1 mb-1 fs-2">
                {{ $bradcrumb }}
            <small class="text-muted fs-6 fw-normal ms-1"></small></h1>
            <!--end::Heading-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb fw-bold fs-base mb-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                @if($bradcrumb !== 'Dashboard')
                    <li class="breadcrumb-item text-dark">{{ $bradcrumb }}</li>
                @endif
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--begin::Page title-->
        
        <!--end::Page title=-->
        <!--begin::Logo bar-->
        <div class="d-flex d-lg-none align-items-center flex-grow-1">
            <!--begin::Aside Toggle-->
            <div class="btn btn-icon btn-circle btn-active-light-primary ms-n2 me-1" id="kt_aside_toggle">
                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                <span class="svg-icon svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5"></rect>
                            <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3"></path>
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Aside Toggle-->
            <!--begin::Logo-->
            <a href="{{ route('admin.dashboard') }}" class="d-lg-none">
                Hookah
            </a>
            <!--end::Logo-->
        </div>
        <!--end::Logo bar-->
        <!--begin::Toolbar wrapper-->
        <div class="d-flex align-items-stretch flex-shrink-0">
            <!--begin::User-->
            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                    <img alt="Pic" src="{{ asset('images/avatar-blank.png') }}">
                </div>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px symbol-circle me-5">
                                <img alt="Logo" src="{{ asset('images/avatar-blank.png') }}">
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bolder d-flex align-items-center fs-5">
                                    {{auth()->user()->name ?? 'User'}}
                                </div>
                                <a href="#" class="fw-bold text-muted text-hover-primary fs-7">
                                    {{auth()->user()->email ?? 'User'}}
                                </a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('admin.profile') }}" class="menu-link px-5">Profile</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ route('logout') }}" class="menu-link px-5">Sign Out</a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User -->
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Container-->
</div>