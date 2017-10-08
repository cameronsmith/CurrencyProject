@extends ('layouts.master')

@section ('content')
    <form method="POST" action="/">
        {{ csrf_field() }}
        <input name="date" class="flatpickr flatpickr-input" type="text" placeholder="Select Date.." value="">
        <input type="submit" value="save">
    </form>
@endsection