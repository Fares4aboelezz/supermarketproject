<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function index(){
        return view('auth.register');
    }
    public function create(Request $request){
     $data=  $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email|string',
            'password'=> 'required|min:8|confirmed',
            'phone'=>'required|min:11|max:11'
        ]);

        User::create([
'name'=>$request->name,
'email'=>$request->email,
'password'=>Hash::make($request->password),
'phone'=>$request->phone
        ]);
        return view('home');
    }


}
