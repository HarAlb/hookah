@extends('layouts.admin')

@section('content')
<div class="card">
    
    <div class="card-header align-items-center border-0 mt-5">
        <h3 class="card-title align-items-center flex-row">
                <span class="fw-boldest text-dark fs-2">Tables</span>
        </h3>
        <div class="ml-auto text-end fs-2 d-flex align-items-center">
            <i class="cursor-pointer bi bi-dash-circle mx-1 fs-2 destroy-table"></i>
            <span class="text-gray-400 fw-bold mx-1">{{ $tables->count() }}</span>
            <i class="cursor-pointer bi bi-plus-circle mx-1 fs-2 uppend-table"></i>
        </div>
    </div>
    <div id="tables-body" class="card-body px-2 py-2 px-sm-9">
        @if($tables->count())
        <div class="row tables-content flex-sm-row flex-xs-row flex-column">
            @foreach($tables as $table)
                <div class="p-2 col-12 col-sm-3 col-xs-6" data-id="{{ $table->id }}" data-products="{{ isset($products[$table->id]) ? json_encode($products[$table->id]) : 0 }}">
                    <div class="position-relative py-12 rounded text-center bg-{{ $table->closed ? 'light' : 'primary cursor-pointer' }}">
                        <span>{{ $table->id }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <h2 class="my-7 py-5">Tables not exists, Create it with one click!</h2>
        @endif
    </div>
</div>

<div class="modal fade" tabindex="-1" id="orders-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Orders</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="row">
                    
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger remove-orders me-auto">Close Table</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-bill-order">Bill</button>
            </div>
        </div>
    </div>
</div>

@endsection