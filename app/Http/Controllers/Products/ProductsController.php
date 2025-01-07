<?php

namespace App\Http\Controllers\Products;

use App\Models\Product\Cart;
use Illuminate\Http\Request;
use App\Models\Product\Order;
use App\Models\Product\Booking;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function singleProduct(Product $product)
    {

        $relatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->orderBy('id', 'desc')
            ->get();

        // checking for Products in cart

        $checkingInCart = Cart::where('product_id', $product->id)->where('user_id', auth()->id())->count();

        return view('products.productSingle', compact('product', 'relatedProducts', 'checkingInCart'));
    }

    public function addCart(Request $request, Product $product)
    {
        $addCart = Cart::create([
            'product_id' => $request->pro_id,
            'name' => $request->pro_name,
            'price' => $request->pro_price,
            'image' => $request->pro_image,
            'user_id' => auth()->id(),
        ]);

        return to_route('product.single', $product)->with(['success' => "product added to cart successfuly"]);
    }


    public function cart()
    {
        $cartProducts = Cart::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        $totalPrice = Cart::where('user_id', auth()->id())->sum('price');
        return view('products.cart', compact('cartProducts', 'totalPrice'));
    }

    public function deleteProductCart(Cart $cart)
    {
        $cart->delete();

        return redirect()->back()->with(['delete' => "product deleted successfuly"]);
    }


    public function prepareCheckout(Request $request)
    {
        $value = $request->price;

        $price = Session::put('price', $value);

        $newPrice = Session::get($price);

        if ($newPrice) {
            return redirect(route('checkout'));
        }
    }

    public function checkout()
    {
        return view('products.checkout');
    }

    public function storeCheckout(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);


        $checkout = Order::create($request->all());

        echo "welcom to paypal payment";
    }


    public function bookTables(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        // dd(  date('n/j/Y') , $request->date  , Carbon::createFromFormat("n/j/Y" ,$request->date));

        if (now()->greaterThan(Carbon::createFromFormat('n/j/Y', $request->date))) {

            return to_route('home')->with(['date' => "invalide date, choose a date in the future "]);
        }
        $normailizetime = str_replace(['pm', 'am'], '', $request->time . ":" . now()->format('s'));
        $normailize = Carbon::createFromFormat('n/j/Y', $request->date)->format('Y-m-d');

        $request->merge(['date' => $normailize, 'time' => $normailizetime, 'user_id' => auth()->id()]);

        $bookTables = Booking::create($request->all());

        return redirect()->back()->with(['success' => "your book create successfuly"]);
    }



    public function menu()
    {

        $drinks = Product::where('type', 'drinks')->orderByDesc('id')->take(4)->get();

        $desserts = Product::where('type', 'desserts')->orderByDesc('id')->take(4)->get();


        return view('products.menu', compact('drinks', 'desserts'));
    }

    /**
     * <div class="row">
                                        @foreach ($drinks as $drink)
                                            <div class="col-md-4 text-center">
                                                <div class="menu-wrap">
                                                    <a href="{{ route('product.single', $drink) }}"
                                                        class="menu-img img mb-4"
                                                        style="background-image: url({{ asset('assets/images/' . $drink->image) }});"></a>
                                                    <div class="text">
                                                        <h3><a
                                                                href="{{ route('product.single', $drink) }}">{{ $drink->name }}</a>
                                                        </h3>
                                                        <p>{{ $drink->descerption }}</p>
                                                        <p class="price"><span>${{ $drink->price }}</span></p>
                                                        <p><a href="{{ route('product.single', $drink) }}"
                                                                class="btn btn-primary btn-outline-primary">Show</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
     */
}
