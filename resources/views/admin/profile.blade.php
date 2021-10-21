@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body p-10 p-lg-15">
            <h1 class="anchor fw-bolder mb-5" id="custom-form-control">
                <a href="#custom-form-control"></a>Profile 
            </h1>
            <div class="py-5">
                <div class="rounded border p-10">
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if ($message = session('show-message'))
                            <input type="hidden" class="show-message" data-message="{{ $message['message'] }}" data-success="{{ $message['success'] }}">
                        @endif
                        <div class="mb-10">
                            <label class="form-label">Name</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Put your name" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email', auth()->user()->email) }}">
                            @error('email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label class="form-label">Password again</label>
                            <input name="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Again">
                        </div>
                        <button class="btn btn-primary">Change</button>
                    </form>
                </div>
            </div>  
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection