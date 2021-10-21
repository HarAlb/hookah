@extends('layouts.app')

@section('content')
    <div class="container pt-2">
        <div class="col-md-6 col-lg-4 p-2 rounded shadow m-auto">
            <div class="text-center">
                <a class="navbar-brand color-green" style="font-size:30px;" href="{{ url('/') }}">
                    {{ config('app.name', 'HookahArt') }}
                </a>
            </div>
            <form action="" class="material py-2" method="POST" autocomplete="off">
                @csrf
                <div class="group">
                    <input id="email" name="email" type="email" required value="{{old('email' ,'')}}" class="@error('email') is-invalid @enderror">
                    <span class="bar"></span>
                    <label for="email">Email</label>
                    @error('email')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="group">
                    <input id="password" name="password" type="password" class="@error('password') is-invalid @enderror"  autocomplete="off">
                    <span class="bar"></span>
                    <label for="email">Password</label>
                    @error('password')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <button class="btn background-color-brand w-100 text-white" type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/script.js') }}" defer></script>
@endsection