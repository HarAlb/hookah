@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body p-10 p-lg-15">
        <h1 class="anchor fw-bolder mb-5" id="custom-form-control">
            <a href="#custom-form-control"></a>{{ $create ? 'Create' : 'Edit' }} product
        </h1>
        <div class="py-5">
            <form
                action="{{ $create ? route('products.store') : route('products.update', ['product' => $product->id]) }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @if(!$create)
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $product->id }}"/>
                @endif
                <div class="my-5">
                    <div class="text-center cursor-pointer file-upload">
                        @if($create)
                            <i class="bi bi-file-earmark-image display-1"></i>
                        @else
                            <img src="{{ asset('uploads/products/' . $product->thumbnail) }}" alt="">
                        @endif
                    </div>
                    <input name="thumbnail" type="file" class="d-none hidden @error('thumbnail') is-invalid @enderror" accept="image/*">
                    @error('thumbnail')
                        <span class="invalid-feedback text-center">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="my-5 d-flex flex-column flex-sm-row">
                    <div class="col px-sm-1">
                        <label for="category" class="required form-label">Category</label>
                        <select id="category" name="category_id" class="form-select @error('category_id') is-invalid  @enderror" data-control="select2"
                            data-placeholder="Select an option">
                            <option></option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $create ? ((old('category_id') == $category->id) ? 'selected' : '') : ($product->category->first()->id == $category->id ? 'selected' : '' )  }}>
                                {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col px-sm-1 my-2 my-sm-0">
                        <label class="form-label required">Price</label>
                        <div class="d-flex align-items-start">
                            <div class="w-100">
                                <input name="price" type="text" class="form-control @error('price') is-invalid @enderror rounded-end-0 border-end-0"
                                    placeholder="Price"
                                    value="{{ old('price', !$create ? $product->price : '') }}">
                                    @error('price')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror       
                            </div>
                            <select name="currency_id" id="" class="form-select form-select-solid col rounded-start-0 w-auto border border-start-0 @error('price') border-danger @enderror">
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{  $create ? ($currency->name === 'Euro' ? 'selected' : '') : ($product->currency->id === $currency->id ? 'selected' : '' ) }}>{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('currency')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="form-label required">Position</label>
                        <input name="position" type="number" class="form-control @error('position') is-invalid @enderror"
                            value="{{ old('position', !$create ? $product->position : $lastPosition) }}">
                        @error('position')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="my-5">
                    <label class="form-label required">Title</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        placeholder="Product title" value="{{ old('title', !$create ? $product->title : '') }}">
                    @error('title')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="my-5">
                    <label class="form-label">Description</label>
                    <input name="desc" type="text" class="form-control @error('desc') is-invalid @enderror"
                        placeholder="Product description" value="{{ old('desc', !$create ? $product->desc : '') }}">
                    @error('desc')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <button class="btn btn-primary">{{ $create ? 'Create' : 'Update' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection