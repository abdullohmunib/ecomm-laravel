<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth:api', ['except' => 'index']);
    }

    public function index()
    {
        
        $orders = Order::all();
        return response()->json([
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
        for ($i=0; $i < count($request['id_produk']); $i++) {
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
            'data' => $Order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $Order)
    {
        //
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
        for ($i=0; $i < count($request['id_produk']); $i++) {
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
            'message' => 'success',
            'data'    => $order
        ]);
    }

    public function dikonfirmasi()
    {
        $orders = Order::where('status', 'Dikonfirmasi')->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    public function dikemas()
    {
        $orders = Order::where('status', 'Dikemas')->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    public function dikirim()
    {
        $orders = Order::where('status', 'Dikirim')->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    public function diterima()
    {
        $orders = Order::where('status', 'Diterima')->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    public function selesai()
    {
        $orders = Order::where('status', 'selesai')->get();
        return response()->json([
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
            'message' => 'success'
        ]);
    }
}
