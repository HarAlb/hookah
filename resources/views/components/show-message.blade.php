@if ($message = session('show-message'))
    <input type="hidden" class="show-message" data-message="{{ $message['message'] }}" data-success="{{ $message['success'] }}">
@endif