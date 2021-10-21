@extends('layouts.admin')

@section('content')
    <div class="row g-xl-8">
        <div class="col-xxl-7">
            <div class="row g-xl-8">
                <!--begin:::Col-->
                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-body p-0 d-flex justify-content-between flex-column">
                            <div class="d-flex flex-stack card-p flex-grow-1">
                                <div class="d-flex flex-column text-start">
                                    <a href="{{ route('users.index') }}" class="fw-boldest text-gray-800 text-hover-primary fs-2">Users</a>
                                    <span class="text-gray-400 fw-bold fs-6">Sep 1 - Sep 16 2020</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Col-->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/widgets.js') }}"></script>
@endsection