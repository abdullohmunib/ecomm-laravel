<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
            // create token
            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'token' => $token
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Email or password is incorrect'
        ]);
     }

    public function register(Request $request)
    {
        // validation input
        $validator = Validator::make($request->all(), [
            "nama_member" => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'detail_alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $request['password'] = bcrypt($request->password);
        unset($request['konfirmasi_password']);
        $Member = Member::create($request->all());
        return response()->json([
            'data' => $Member
        ]);
    }

    public function login_member(Request $request)
    {
        // validation input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $member = Member::where('email', $request->email)->first();
        if ($member) {
            if (Hash::check($request->password, $member->password)) {
                $request->session()->regenerate();
                return response()->json([
                    'message'=>'Success',
                    'data' => $member
                ], 200);
            } else {
                return response()->json([
                    'message'=>'Failed',
                    'data' => 'password is incorrect'
                ], 422);
            }
        }else{
            return response()->json([
                'message' => 'failed',
                'data' => 'email is incorrect'
            ]);
        }
        
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function logout_member()
    {
        Session::flush();
        return redirect('/login_member');
    }
} 
