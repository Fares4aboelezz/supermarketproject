<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\str;

class ForgotPasswordController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    public function forget(){
        return view('auth.passwords.reset');
    }

    public function forgetpass(Request $request){
$request->validate([
    'email'=>'required|email|unique:users',
]);
$token=str::random(60);

User::create([
'email'=>$request->email,
'token'=>$token,
'created_at' => Carbon::now(),

]);
Mail::send('auth.emails.forget_pass',['token'=>$token],function ($message) use($request){
$message->to($request->email);
$message->subject('Reset password');
});
return redirect()->to(route('forget.pass'))->with('success','we sent to you message');
    }

    public function reset($token){
        return view('auth.passwords.new password',compact('token'));
    }

    public function resetpass(Request $request){
        $request->validate([
'email'=>'required|email|exists:users',
'password'=>'required|string|min:8|confirmed',
'password_confirmation'=>'required',
        ]);
$updatepass=DB::table('password_resets')->where([
'email'=>$request->email,
'token'=>$request->token,
])->first();

        if(!$updatepass){
            return redirect()->to(route('reset.pass'))->with('error','invalid');
        }
        User::where('email',$request->email)->update(['password' =>Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=>$request->email])->delete();
        return redirect()->to(route('login'))->with('success','password reset');
    }

    }


