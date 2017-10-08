@if (Session::has('success_message'))
    <div class="notification is-primary flash-messages">
        <ul>
            {{ Session::get('success_message') }}
        </ul>
    </div>
@endif