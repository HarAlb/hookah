@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body p-10 p-lg-15">
        <h1 class="anchor fw-bolder mb-5" id="custom-form-control">
            <a href="#custom-form-control"></a>{{ $create ? 'Create' : 'Edit' }} category
        </h1>
        <div class="py-5">
            <form action="{{ $create ? route('categories.store') : route('categories.update', ['category' => $category->id]) }}" method="POST">
                @csrf
                @if(!$create)
                    @method('PUT')
                @endif
                <div class="my-5">
                    <label class="form-label">Name</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Category name" value="{{ old('name', !$create ? $category->name : '') }}">
                    @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <button class="btn btn-primary" type="submit">{{ $create ? 'Create' : 'Edit'}}</button>
            </form>
            @include('components.show-message')
        </div>
    </div>
</div>
@endsection