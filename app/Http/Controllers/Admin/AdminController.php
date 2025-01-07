<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginView()
    {

        return view('admins.login');
    }


    public function checkLogin(Request $request)
    {

        $remeberMe = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remeberMe)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }


    public function checklogout()
    {

        auth()->guard('admin')->logout();

        return view('admins.login');
    }

    public function index()
    {

        $productsCounts = Product::count();
        $ordersCounts = Order::count();
        $bookingsCounts = Booking::count();
        $adminsCounts = Admin::count();

        return view('admins.index', compact('productsCounts', 'ordersCounts', 'bookingsCounts', 'adminsCounts'));
    }


    public function DisplayAdmins()
    {

        $admins = Admin::orderByDesc('id')->get();

        return view('admins.allAdmins', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            "name" => 'required',
            "email" => 'required',
            "password" => 'required',

        ]);

        $storeAdmin = Admin::create([
            'name' => $request->name,
            'email' => $request->name,
            'password' => Hash::make($request->name),
        ]);

        if ($storeAdmin) {
            return redirect()->route('all.admins')->with(['success' => "admin created successfuly"]);
        }
    }

    public function DisplayOrders()
    {
        $orders = Order::orderByDesc('id')->get();
        return view('admins.allOrders', compact('orders'));
    }

    public function editOrder(Order $order)
    {
        return view('admins.editOrder', compact('order'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $request->validate([
            "status" => 'required',
        ]);

        $order->update($request->all());

        if ($order) {
            return redirect()->route('all.orders')->with(['updated' => "order updated successfully"]);
        }
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();

        if ($order) {
            return redirect()->route('all.orders')->with(['deleted' => "order deleted successfully"]);
        }
    }


    public function DisplayProducts()
    {
        $products = Product::orderByDesc('id')->get();

        return view('admins.allProducts', compact('products'));
    }


    public function createProducts(Request $request)
    {

        return view('admins.createProduct');
    }

    public function storeProducts(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "price" => 'required',
            "image" => 'required',
            "description" => 'required',
            "type" => 'required',
        ]);

        $path = 'assets/images';
        $fileName = $request->image->getClientOriginalName();
        $request->image->move(public_path($path), $fileName);


        $storeProduct = Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "image" => $fileName,
            "description" => $request->description,
            "type" => $request->type,
        ]);

        if ($storeProduct) {
            return redirect()->route('all.products')->with(['created' => "product created successfully"]);
        }
    }


    public function deleteProduct(Product $product)
    {
        if (File::exists(public_path('assets/images/' . $product->image))) {
            File::delete(public_path('assets/images/' . $product->image));
        }

        $product->delete();

        if ($product) {
            return redirect()->route('all.products')->with(['delete' => "product deleted successfully"]);
        }
    }


    public function DisplayBookings()
    {
        $bookings = Booking::orderByDesc('id')->get();

        return view('admins.allBookings' , compact('bookings'));
    }

    public function deleteBookings(Booking $booking)
    {
        $booking->delete();

        if ($booking) {
            return redirect()->route('all.bookings')->with(['delete' => "allBooking deleted successfully"]);
        }

    }
}
