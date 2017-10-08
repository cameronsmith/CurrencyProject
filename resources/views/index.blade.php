@extends ('layouts.master')

@section ('content')
<section class="section">
    <div class="container">
        <form method="POST" action="/rates">
            {{ csrf_field() }}
            <div class="columns">
                <div class="column">
                    <input name="birthday_date" class="flatpickr flatpickr-input" type="text" placeholder="Please select your birthday" value="">
                </div>
                <div class="column is-one-quarter">
                    <input class="button is-primary" type="submit" value="Fetch Rates">
                </div>
            </div>
        </form>
    </div>
</section>
@endsection