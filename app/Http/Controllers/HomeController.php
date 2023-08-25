<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Subcategory;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $sliders = Slider::all();
        $testimonis = Testimoni::all();
        $products = Product::skip(0)->take(8)->get();
        return view('home.index', compact(['categories', 'sliders', 'testimonis', 'products']));
    }
    public function products($subcategory)
    {
        $products = Product::where('id_subkategori', $subcategory)->get();
        return view('home.products', compact('products'));
    }
    public function product($id)
    {
        $product = Product::find($id);
        $latest_product = Product::orderByDesc('created_at')->offset(0)->limit(10)->get();
        return view('home.product', compact(['product', 'latest_product']));
    }
    public function cart()
    {
        return view('home.cart');
    }
    public function checkout()
    {
        return view('home.checkout');
    }
    public function orders()
    {
        return view('home.orders');
    }
    public function about()
    {
        $about = About::first();
        $testimonis = Testimoni::all();
        return view('home.about', compact(['about', 'testimonis']));
    }
    public function contact()
    {
        $about = About::first();
        return view('home.contact', compact(['about']));
    }
    public function faq()
    {
        return view('home.faq');
    }


}
