@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header align-items-center border-0 mt-5">
        <h3 class="card-title align-items-center flex-row">
                <span class="fw-boldest text-dark fs-2">Categories</span>
                <span class="text-gray-400 fw-bold fs-2 ms-4">{{ $count }}</span>
        </h3>
        <div class="ml-auto text-end">
            <a href="{{ route('categories.create') }}" class="btn btn-bg-primary btn-color-white rounded-2">
                Create
            </a>
        </div>
    </div>
    <div class="card-body px-2 py-2 px-sm-9" data-type="categories">
        @foreach ($categories->where('parent_id',0) as $category)
            <div class="d-flex align-items-center my-5 border py-2">
                <div class="symbol symbol-circle me-4 p-2 p-sm-2">
                    <i class="bi bi-card-list fs-3x fs-sm-1 align-middle"></i>
                </div>
                <div class="d-flex flex-column min-w-150px me-4">
                    <a href="{{ route('categories.edit' , ['category' => $category->id]) }}" class="fw-boldest text-gray-800 text-hover-primary fs-4">{{ $category->name }}</a>
                    <div class="fw-bold fs-6 text-gray-400">Products count {{ $category->products_count }}</div>
                </div>
                <a class="btn btn-active-danger ms-auto btn-remove p-2 py-sm-2 px-sm-5" href="{{ route('categories.destroy', ['category' => $category->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </a>
            </div>
        @endforeach

        {{-- If will be created categories with subs }}
        {{-- <ul id="sortable" class="my-5 list-group border-0">
            @foreach ($categories->where('parent_id',0) as $category)
                <li class="list-group-item">
                    <span>{{ $category->name }}</span>
                    @if($subCategories = $categories->where('parent_id', $category->id))
                        <ul> 
                            @foreach ($subCategories as $subCategory)
                            <li class="list-group-item">
                                <span>{{ $subCategory->name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul> --}}
        @if(!$count)
            <h2 class="my-7 py-5">Categories are empty</h2>
        @endif
    </div>
</div>
@include('components.show-message')
@endsection
