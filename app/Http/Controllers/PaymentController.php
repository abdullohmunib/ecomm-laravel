<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'edit', 'destroy']);
    }

    public function list()
    {
        return view('payment.index');
    }

    public function index()
    {
        //
        $payment = Payment::with('order')->get();
        return response()->json([
            'data' => $payment
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
            "nama_payment" => 'required',
            "deskripsi" => 'required',
            "gambar" => 'required|image|mimes:jpg,png,jpeg,webp'
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        // get image
        $input = $request->all();
        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }


        $Payment = Payment::create($input);
        return response()->json([
            'success' => true,
            'data' => $Payment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $Payment)
    {
        return response()->json([
            'data' => $Payment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $Payment)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $Payment)
    {
        $validator = Validator::make($request->all(), [
            "status" => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $Payment->update([
            'status' => $request['status']
        ]);
        return response()->json([
            'success' => true,
            'data' => $Payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $Payment)
    {
        File::delete('uploads/' . $Payment->gambar);
        $Payment->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
