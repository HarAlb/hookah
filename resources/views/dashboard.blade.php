@extends('layouts.app')

@section('content')
<div class="container-fluid mt--7">
    @if(session('pin-exists'))
        @include('components.dashboard-tables')
    @else
    <div class="modal fade" tabindex="-1" id="pin-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Check Pin</h5>
                </div>
                
                <div class="modal-body py-1">
                    <form id="submit-pin" action="{{ route('check.pin') }}" class="material" method="POST" autocomplete="off">
                        <div class="group my-8">
                            <input id="pin" name="pin" type="text" required maxlength="4" value="" class="">
                            <span class="bar"></span>
                            <label for="pin">Pin</label>
                            <span class="invalid-feedback">
                                Pin is not valid
                            </span>
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-2">
                    <button for="submit-pin" type="submit" class="btn btn-success fs-14 submit">Enter</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/script.js') }}" defer></script>
@endsection