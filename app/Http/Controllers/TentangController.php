<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TentangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'update']);
        // $this->middleware('auth:api')->only(['update']);
    }
    public function index()
    {
        $about = About::first();
        return view('tentang.index', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        // get image
        $input = $request->all();
        if ($request->has('logo')) {
            // delete image before
            File::delete('uploads/' . $about->logo);
            $logo = $request->file('logo');
            $nama_logo = time() . rand(1, 9) . '.' . $logo->getClientOriginalExtension();
            $logo->move('uploads', $nama_logo);
            $input['logo'] = $nama_logo;
        } else {
            unset($input['logo']);
        }

        $about->update($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $about
        ]);
    }
} 
