<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthOtpController extends Controller
{
    public function login(){
        return view('auth.otp-login');
    }
    public function generate(Request $request){

        $request->validate([
'phone'=>'required|exists:users,phone',
        ]);

          $verificationCode = $this->generateOtp($request->phone);

          $message = "Your OTP To Login is - ".$verificationCode->otp;

          return redirect()->route('otp.verification', ['user_id' => $verificationCode->user_id])->with('success',  $message);
    }

    public function generateOtp($phone)
    {
        $user = User::where('phone', $phone)->first();

        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }
        return VerificationCode::create([
'user_id'=>$user->id,
'otp'=>rand(123456 , 999999),
'expire_at'=>Carbon::now()->addMinutes(30),
        ]);

    }
        public function verification($user_id)
        {
            return view('auth.otp-verification')->with([
                'user_id' => $user_id
            ]);
        }
        public function loginWithOtp(Request $request)
        {

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'otp' => 'required'
            ]);

            $verificationCode   = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

            $now = Carbon::now();
            if (!$verificationCode) {
                return redirect()->back()->with('error', 'Your OTP is not correct');
            }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
                return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
            }

            $user = User::whereId($request->user_id)->first();

            if($user){

                $verificationCode->update([
                    'expire_at' => Carbon::now()
                ]);

                Auth::login($user);

                return redirect('/home');
            }

            return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
        }
    }




