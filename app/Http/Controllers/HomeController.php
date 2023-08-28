<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Subcategory;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth')->only('add_to_cart');
    // }
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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 9372073f14e462197de9e792d463e9a5"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        }
        $provinsi = json_decode($response);

        if (!Auth::guard('webmember')->user()) {
            return redirect('/login_member');
        }
        $carts = Cart::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout' , 0)->get();
        $carts_subtotal = Cart::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout' , 0)->sum('total');
        return view('home.cart', compact(['carts', 'provinsi', 'carts_subtotal']));
    }

    public function get_kabupaten($id_province)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.rajaongkir.com/starter/city?province=' . $id_province,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 9372073f14e462197de9e792d463e9a5"
            ),
            ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }  
    }

    public function get_ongkir($destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=18&destination=".$destination."&weight=".$weight."&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 9372073f14e462197de9e792d463e9a5"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }

    public function checkout()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 9372073f14e462197de9e792d463e9a5"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        }
        $provinsi = json_decode($response);


        $about = About::first();
        $orders = Order::where('id_member', Auth::guard('webmember')->user()->id)->first();
        return view('home.checkout', compact(['about', 'orders', 'provinsi']));
    }

    public function checkout_orders(Request $request)
    {
        // get id that last input
       $id = DB::table('orders')->insertGetId([
            'id_member' => $request->id_member,
            'invoice' => date('ymds'),
            'grand_total' => $request->grand_total,
            'status' => 'Baru',
            'created_at' => date('Y-m-d H:i:s') 
        ]);

        for ($i=0; $i < count($request->id_produk); $i++) {
            DB::table('order_details')->insert([
                'id_order' => $id,
                'id_produk' => $request->id_produk[$i],
                'jumlah' => $request->jumlah[$i],
                'size' => $request->ukuran[$i],
                'color' => $request->warna[$i],
                'total' => $request->total[$i],
                'created_at' => date('Y-m-d H:i:s') 
            ]);
        }

        Cart::where('id_member', Auth::guard('webmember')->user()->id)->update([
            'is_checkout' => 1 
        ]);

    }

    public function payments(Request $request)
    {
        Payment::create([
            'id_order' => $request->id_order,
            'id_member' => Auth::guard('webmember')->user()->id,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => '',
            'detail_alamat' => $request->detail_alamat,
            'status' => 'Pending',
            'atas_nama' => $request->atas_nama,
            'no_rekening' => $request->no_rekening,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/orders');
    }

    public function orders()
    {
        $orders = Order::where('id_member', Auth::guard('webmember')->user()->id)->get();
        $payments = Payment::where('id_member', Auth::guard('webmember')->user()->id)->get();
        return view('home.orders', compact(['orders', 'payments']));
    }

    public function pesanan_selesai(Order $order)
    {
        $order->status = "Selesai";
        $order->save();
        return redirect('/orders');
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

    public function add_to_cart(Request $request)
    {
        Cart::create($request->all());

    }

    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }




}
