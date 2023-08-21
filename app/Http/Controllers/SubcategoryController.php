<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {
        $categories = Category::all();
        return view('subkategori.index', compact('categories'));
    }

    public function index()
    {
        //
        $subcategories = Subcategory::with('category')->get();
        return response()->json([
            'data' => $subcategories
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
            "nama_subkategori" => 'required',
            "id_kategori" => 'required',
            "deskripsi" => 'required',
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


        $Subcategory = Subcategory::create($input);
        return response()->json([
            'success' => true,
            'data' => $Subcategory
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $Subcategory)
    {
        return response()->json([
            'data' => $Subcategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $Subcategory)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $Subcategory)
    {

        // validation input
        $validator = Validator::make($request->all(), [
            "nama_subkategori" => 'required',
            "id_kategori" => 'required',
            "deskripsi" => 'required',
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
            // delete image before
            File::delete('uploads/' . $Subcategory->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        $Subcategory->update($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $Subcategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $Subcategory)
    {
        File::delete('uploads/' . $Subcategory->gambar);
        $Subcategory->delete();
        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
