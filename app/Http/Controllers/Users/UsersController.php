<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function displayOrders()
    {
        $orders =  Order::where('user_id', auth()->id())->orderByDesc('id')->get();

        return view('users.orders', compact('orders'));
    }

    public function bookings()
    {
        $bookings =  Booking::where('user_id', auth()->id())->orderByDesc('id')->get();

        return view('users.bookings', compact('bookings'));
    }
}
