@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header align-items-center border-0 mt-5">
        <h3 class="card-title align-items-center flex-row">
                <span class="fw-boldest text-dark fs-2">Products</span>
                <span class="text-gray-400 fw-bold fs-2 ms-4">{{ $listProducts->total() }}</span>
            </h3>
            <div class="ml-auto text-end">
                <a href="{{ route('products.create') }}" class="btn btn-bg-primary btn-color-white rounded-2">
                    Create
                </a>
            </div>
    </div>
    <div class="card-body px-2 py-2 px-sm-9">
        <form class="my-2 mx-3 mx-sm-0">
            <div class="">
                <label class="form-label">Search</label>
                <input name="search" type="text" class="form-control fs-7" placeholder="Title,Desc" value="{{ request()->get('search') ?: '' }}">
            </div>
            <div class="d-flex flex-column flex-sm-row">
                <div class="col-sm my-3 my-sm-2 pe-sm-2">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category_id" class="form-select" data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm my-3 my-sm-2 pe-sm-2">
                    <div class="d-flex">
                        <div class="col">
                            <label class="form-label">Order by</label>
                            <select id="position" name="orderBy" class="form-select" data-control="select2"
                                data-placeholder="Select an option">
                                <option></option>
                                @foreach ($orderList as $order)
                                <option value="{{ $order }}" {{ request('orderBy') == $order ? 'selected' : '' }}>
                                    {{ $order }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 col-sm-3">
                            <label class="form-label">Sort by</label>
                            <select id="sort" name="sort" class="form-select" data-control="select2">
                                <option value="1" {{ request('sort') === "1" ? 'selected' : ''}}>Asc
                                </option>
                                <option value="0" {{ request('sort') === "0" ? 'selected' : ''}}>Desc</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary my-2">Search</button>
        </form>
        <div class="separator my-5"></div>
        @if($listProducts->count())
        <div class="d-flex mx-n2 flex-column flex-sm-row flex-wrap">
            @foreach ($listProducts as $product)
            <div class="p-2 col-sm-4 col-12 my-sm-5 pb-2">
                <div class="d-flex flex-column align-items-center overflow-hidden text-center border rounded product-hover-shadow h-100">
                    <div class="position-relative">
                        <span class="position-absolute product-position">{{ $product->position }}</span>
                        <img class="mw-100" src="{{ asset('uploads/products/' . $product->thumbnail) }}" alt="{{ $product->title }}">
                    </div>
                    <div class="d-flex flex-column my-2 align-items-center w-100">
                        <a class="fw-boldest text-gray-800 text-hover-primary fs-4 text-truncate mw-90" href="{{ route('products.edit', ['product' => $product->id]) }}">{{ $product->title }}</a>
                         {{-- Now we use just one category --}}
                         <span class="badge badge-success my-1">{{ $product->categories->first()->name }}</span>
                         <span class="fw-boldest text-gray-600 my-1 fs-3">Price: {{ $product->price }} <span class="ba {{ $product->currency->icon }}"></span></span>
                    </div>
                    <a class="btn btn-active-danger ms-auto btn-remove py-sm-2 px-sm-5 me-2 my-1" href="{{ route('products.destroy', ['product' => $product->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif  
        @if($listProducts->total())
            {{ $listProducts->links() }}
        @else
            <h2 class="my-7 py-5">
                {{ request()->get('search') ? 'Search result is empty' : 'Products not exists'}}
            </h2>
        @endif
    </div>
    @include('components.show-message')
</div>
@endsection