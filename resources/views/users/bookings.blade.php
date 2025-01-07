@extends('layouts.app')

@section('content')
    <section class="home-slider owl-carousel">

        <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">

                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">My bookings</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home</a></span>
                            <span>My bookings</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table table-dark">
                            <thead style="background-color: #c49b63; height: 60px;">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bookings->count() )

                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->first_name }}</td>
                                        <td>{{ $booking->last_name }}</td>
                                        <td>{{ $booking->date }}</td>
                                        <td>{{ $booking->time }}</td>
                                        <td>{{ $booking->phone }}</td>
                                        <td>{{ $booking->message }}</td>
                                    </tr>
                                @endforeach

                                @else

                                <p class="alert alert-success">you have no bookings just yet</p>

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
