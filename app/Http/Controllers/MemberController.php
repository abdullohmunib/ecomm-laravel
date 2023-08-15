<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
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
        //
        $categories = Member::all();
        return response()->json([
            'data' => $categories
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
            "nama_member" => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'detail_alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $Member = Member::create($request->all());
        return response()->json([
            'data' => $Member
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $Member)
    {
        return response()->json([
            'data' => $Member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $Member)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $Member)
    {

        // validation input
        $validator = Validator::make($request->all(), [
            "nama_member" => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'detail_alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $Member->update($request->all());
        return response()->json([
            'message' => 'success',
            'data' => $Member
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $Member)
    {
        $Member->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
}
