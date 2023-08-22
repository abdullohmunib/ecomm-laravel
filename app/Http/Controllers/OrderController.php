<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['baru_list', 'dikonfirmasi_list', 'dikemas_list', 'dikirim_list', 'diterima_list', 'selesai_list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy', 'ubah_status', 'baru', 'dikonfirmasi', 'dikemas', 'dikirim', 'diterima', 'selesai']);
    }

    public function baru_list()
    {
        return view('pesanan.baru');
    }

    public function dikonfirmasi_list()
    {
        return view('pesanan.dikonfirmasi');
    }

    public function dikemas_list()
    {
        return view('pesanan.dikemas');
    }

    public function dikirim_list()
    {
        return view('pesanan.dikirim');
    }

    public function diterima_list()
    {
        return view('pesanan.diterima');
    }

    public function selesai_list()
    {
        return view('pesanan.selesai');
    }

    public function index()
    {

        $orders = Order::with('member')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // validation input
        $validator = Validator::make($request->all(), [
            "id_member" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }
        $Order = Order::create($request->all());

        // input to order_details_table
        for ($i = 0; $i < count($request['id_produk']); $i++) {
            OrderDetail::create([
                'id_order' => $Order['id'],
                'id_produk' => $request['id_produk'][$i],
                'jumlah' => $request['jumlah'][$i],
                'size' => $request['size'][$i],
                'color' => $request['color'][$i],
                'total' => $request['total'][$i],

            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $Order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $Order)
    {
        return response()->json([
            'success' => true,
            'data' => $Order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $Order)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $Order)
    {
        $validator = Validator::make($request->all(), [
            "id_member" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }
        $Order->update($request->all());

        // delete before update
        OrderDetail::where('id_order', $Order['id'])->delete();

        // update data to order_details_table
        for ($i = 0; $i < count($request['id_produk']); $i++) {
            OrderDetail::create([
                'id_order' => $Order['id'],
                'id_produk' => $request['id_produk'][$i],
                'jumlah' => $request['jumlah'][$i],
                'size' => $request['size'][$i],
                'color' => $request['color'][$i],
                'total' => $request['total'][$i],

            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $Order
        ]);
    }

    public function ubah_status(Request $request, Order $order)
    {
        $order->update([
            'status' => $request['status']
        ]);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data'    => $order
        ]);
    }

    public function baru()
    {
        $orders = Order::with('member')->where('status', 'Baru')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function dikonfirmasi()
    {
        $orders = Order::with('member')->where('status', 'Dikonfirmasi')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function dikemas()
    {
        $orders = Order::with('member')->where('status', 'Dikemas')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function dikirim()
    {
        $orders = Order::with('member')->where('status', 'Dikirim')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function diterima()
    {
        $orders = Order::with('member')->where('status', 'Diterima')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function selesai()
    {
        $orders = Order::with('member')->where('status', 'selesai')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $Order)
    {
        File::delete('uploads/' . $Order->gambar);
        $Order->delete();
        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
