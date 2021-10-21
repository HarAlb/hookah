@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body p-10 p-lg-15">
        <h1 class="anchor fw-bolder mb-5" id="custom-form-control">
            <a href="#custom-form-control"></a>{{ !empty($user) ? 'Edit' : 'Create' }} user 
        </h1>
        <div class="py-5">
            <div class="rounded border p-10">
                <form action="{{ !empty($user) ? route('users.update', ['user' => $user->id]) : route('users.store') }}" method="POST">
                    @csrf
                    @if(!empty($user))
                        @method('PUT')
                    @endif
                    <div class="my-5">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email please" value="{{ old('email',!empty($user) ? $user->email : '') }}">
                        @error('email')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="my-5">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="my-5">
                        <label class="form-label">Password confirmation</label>
                        <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation">
                        @error('password_confirmation')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="my-5">
                        <label class="form-label">Pin code</label>
                        <input name="pin" maxlength="4" type="text" class="form-control @error('pin') is-invalid @enderror" placeholder="Put pin code" value="{{ old('pin', !empty($user) ? $user->pin : '') }}">
                        @error('pin')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary">{{ !empty($user) ? 'Update' : 'Create' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection