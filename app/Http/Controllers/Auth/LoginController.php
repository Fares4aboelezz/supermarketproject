<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;

class LoginController extends Controller
{

    public function index(){
        return view('auth.login');
    }
    public function create(Request $request){
$data=$request->validate([
    'name'=>'required|string',
    'email'=>'required|email|unique:users,email',
    'password'=> 'required|min:8',
    'phone'=>'required|min:11|max:11'
]);


if(Auth::attempt($data,$request->input('remember'))){
    $request->session()->regenerate();
    return redirect(route('dashboard'))->with("success","Welcome Back!");
}

return redirect()->back()->with('fail',"Credintial error");
    }
}
