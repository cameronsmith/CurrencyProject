@extends ('layouts.master')

@section ('content')
<section class="section">
    <div class="container">
        <form method="POST" action="/rates">
            {{ csrf_field() }}
            <div class="columns">
                <div class="column">
                    <input name="dob" class="flatpickr flatpickr-input" type="text" placeholder="Please select your birthday" value="">
                </div>
                <div class="column is-one-quarter">
                    <input class="button is-primary" type="submit" value="Fetch Rates">
                </div>
            </div>
        </form>
    </div>
</section>

@isset($rates)
    <section class="section">
        <div class="container">
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Rate</th>
                    <th>Occurrences</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($rates as $rate)
                        <tr>
                            <td>{{ $rate->fetched }}</td>
                            <td>{{ $rate->rate }}</td>
                            <td>{{ $rate->occurrences }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endisset

@endsection