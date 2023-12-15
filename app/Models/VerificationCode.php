<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'otp',
         'expire_at'
        ];
/*
        public function generatecode(){
$this->timestamps=false;
$this->otp=rand(1002,9999);
$this->expire_at=now()->addMinutes(10); //now الوقت اللى احنا فيه
$this->save();
        }
        */
}
