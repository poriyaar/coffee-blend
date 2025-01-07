@extends('layouts.app')

@section('content')
    <section class="home-slider owl-carousel">

        <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">

                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">My orders</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home</a></span>
                            <span>My orders</span>
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
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Price</th>
                                    <th>Email</th>
                                    {{-- <th>Image</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @if ($orders->count() > 0)


                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->first_name }}</td>
                                        <td>{{ $order->last_name }}</td>
                                        <td>{{ $order->state }}</td>
                                        <td>{{ $order->city }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>${{ $order->price }}</td>
                                        <td>{{ $order->email }}</td>

                                        {{-- <td>
                                            <img src="{{ asset('assets/images/'. $order->image ) }}" alt="Product Image"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </td> --}}

                                    </tr>
                                @endforeach
                                @else

                                <p class="alert alert-success">you hane no order just yet</p>

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
