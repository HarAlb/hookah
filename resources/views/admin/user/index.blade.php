@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header align-items-center border-0 mt-5">
        <h3 class="card-title align-items-center flex-row">
                <span class="fw-boldest text-dark fs-2">Users</span>
                <span class="text-gray-400 fw-bold fs-2 ms-4">{{ $countUsers }}</span>
            </h3>
            <div class="ml-auto text-end">
                <a href="{{ route('users.create') }}" class="btn btn-bg-primary btn-color-white rounded-2">
                    Create
                </a>
            </div>
    </div>
    <div class="card-body px-2 py-2 px-sm-9">
        <form class="d-flex flex-sm-row flex-column align-items-sm-end align-items-center">
            <div class="col-sm w-100 w-sm-auto my-5 my-sm-0 pe-sm-2">
                <label class="form-label">Search</label>
                <input name="search" type="text" class="form-control" placeholder="Name,Email" value="{{ request()->get('search') ?: '' }}">
            </div>
            <button class="btn btn-primary">Search</button>
        </form>
        <div class="separator my-5"></div>
        @foreach ($listUsers as $user)
            <div class="d-flex align-items-center my-5">
                <div class="symbol symbol-circle me-4 bg-primary p-1 p-sm-2">
                    <i class="bi bi-person fs-4x fs-sm-2hx text-white"></i>
                </div>
                <div class="d-flex flex-column min-w-150px me-4">
                    <a href="{{ route('users.edit' , ['user' => $user->id]) }}" class="fw-boldest text-gray-800 text-hover-primary fs-4">{{ $user->name }}</a>
                    <div class="fw-bold fs-6 text-gray-400">{{ $user->email }}</div>
                </div>
                <a class="btn btn-active-danger ms-auto btn-remove p-2 py-sm-2 px-sm-5" href="{{ route('users.destroy', ['user' => $user->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </a>
            </div>
        @endforeach
        @if($countUsers)
            {{ $listUsers->links() }}
        @else
            <h2 class="my-7 py-5">
                {{ request()->get('search') ? 'Search result is empty' : 'Users not exists'}}
            </h2>
        @endif
    </div>
    @include('components.show-message')
</div>
@endsection