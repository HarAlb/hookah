@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-6" data-table-id="{{ $table->id }}">
        <div class="row">
            <div class="col-xl-10 mb-5 mb-xl-0 mx-auto px-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-body">
                        {{-- <div class="row tables-content flex-sm-row flex-xs-row flex-column"> --}}
                            <ul class="nav rounded-pill flex-sm-center bg-light overflow-auto p-2 mb-2 flex-stack" id="nav-tab" role="tablist">
                                @foreach ($categories as $k => $category)
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-{{ $k ? 'white' : 'success' }} text-grey btn-active-color-gray-700 py-2 px-4 fs-6 fw-bold" data-bs-toggle="tab" href="#{{ $category->slug }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content px-0">
                                @foreach ($categories as $k => $category)
                                    <div class="tab-pane fade {{ $k ? '' : 'active show'}}" id="{{ $category->slug }}" role="tabpanel" aria-labelledby="{{ $category->slug }}-tab">
                                        <div class="d-flex mx-n2 flex-column flex-sm-row flex-wrap">
                                            @foreach ($category->products as $product)
                                            <div class="p-2 col-sm-3 col-12 my-sm-5 cursor-hover-pointer product" data-id="{{ $product->id }}">
                                                <div class="d-flex flex-column align-items-center overflow-hidden text-center border rounded product-hover-shadow h-100">
                                                    <div class="position-relative">
                                                        <img class="mw-100" src="{{ asset('uploads/products/' . $product->thumbnail) }}" alt="{{ $product->title }}">
                                                    </div>
                                                    <div class="d-flex flex-column my-2 align-items-center w-100 product-title">
                                                        <a class="fw-boldest text-gray-800 text-hover-primary fs-4 text-truncate mw-90" href="{{ route('products.edit', ['product' => $product->id]) }}">{{ $product->title }}</a>
                                                        <span class="fw-boldest text-gray-600 my-1 fs-3 product-price" data-price="{{ $product->price }}">Price: {{ $product->price }} <span class="ba {{ $product->currency->icon }}"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="orders" data-orders="{{ json_encode($orders->toArray()) }}"></div>
    @include('components.basket-modal')
    @include('components.products-slider')
@endsection

@section('scripts')
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>    
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
@endsection
