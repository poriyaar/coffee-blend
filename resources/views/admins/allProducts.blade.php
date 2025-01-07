@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col">
            @if (Session::has('created'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('created') }}</p>
            @endif

            @if (Session::has('delete'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('delete') }}</p>
            @endif
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">coffee Shop products</h5>
                    <a href="{{ route('create.product') }}" class="btn btn-primary mb-4 text-center float-right">Create
                        Products</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">image</th>
                                <th scope="col">price</th>
                                <th scope="col">type</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img src="{{ asset('assets/images/' . $product->image) }}" width="80"
                                            height="70" alt="">
                                    </td>
                                    <td>${{ $product->price }}</td>
                                    <td>{{ $product->type }}</td>


                                    <td><a href="{{ route('delete.product' , $product) }}" class="btn btn-danger  text-center ">delete</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
