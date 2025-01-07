<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

      $products = Product::orderBy('id','desc')->take(4)->get();

        return view('home' , compact('products'));
    }


    public function sevices()
    {
        return view('pages.sevices');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
