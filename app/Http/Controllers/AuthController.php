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

    public function register_member()
    {
        return view('auth.register_member');
    }

    public function register_member_action(Request $request)
    {
        // validation input
        $validator = Validator::make($request->all(), [
            "nama_member" => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|sa me:password',
        ]);
        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/register_member');
        }

        $request['password'] = bcrypt($request->password);
        unset($request['konfirmasi_password']);
        Member::create($request->all());

        Session::flash('success', 'Account successfully created!');
        return redirect('/login_member');
        
    }

    public function login_member()
    {
        return view('auth.login_member');
    }

    public function login_member_action(Request $request)
    {
        // validation input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            Session::flash('failed', $validator->errors()->toArray());
            return redirect('/login_member');
        }

        $credentials = $request->only(['email', 'password']);
        $member = Member::where('email', $request->email)->first();
        if ($member) {
            if (Auth::guard('webmember')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('/');
            } else {
                Session::flash('failed', 'Password incorrect');
                return redirect('/login_member');
            }
        }else{
            Session::flash('failed', 'Email not found');
            return redirect('/login_member');
        }
        
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function logout_member()
    {
        Auth::guard('webmember')->logout();
        Session::flush();
        return redirect('/');
    }
} 
