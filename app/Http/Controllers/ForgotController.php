<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App; 
use Illuminate\Support\Str; 
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class ForgotController extends Controller
{

    public function forget_password(Request $request)
    {  
        if($request->post()){ 

            $request->validate([
                'email' => ['required', 'email','exists:tbl_users'],
            ]);

            $remember_token = Str::random(64);
            
            $getFor = User::where('email',$request->email)->first();
            if(isset($getFor->email) && $getFor->email !=""){ 
                User::where('email',$request->email)->update(['remember_token'=>$remember_token]);

                $checkUser = DB::table('password_resets')->where('email',$getFor->email)->count();
                if($checkUser == 1){
                    DB::table('password_resets')->where('email',$request->email)->update(['token'=>$remember_token,'created_at'=>Carbon::now()]);
                }else{
                    DB::table('password_resets')->insert([
                        'email' => $getFor->email,
                        'token' => $remember_token,
                        'created_at' => now(),  
                    ]);
                } 
                Mail::send('/emails/ForgetPassword', ['token' => $remember_token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password Notification');
                }); 
                return redirect('/login');
            }
        }  
    }

    public function resetPassword(Request $request, $token) { 
        if($request->post()){ 
            $checkUser = DB::table('password_resets')->where('token',$token)->count();

            $passwordReset = DB::table('password_resets')->where('token', $token)->first();

            if (!$passwordReset) {
                session()->flash('success_msg', 'Your token is invalid.');

                $url = route('password.reset', $token);
                return redirect($url);
                //return redirect()->back();
            }

            $tokenCreatedAt = Carbon::parse($passwordReset->created_at);
            $tokenExpiration = $tokenCreatedAt->addHours(3);

            if (now()->gt($tokenExpiration)) {
                session()->flash('success_msg', 'Your token has expired.');
                //return redirect()->back();

                $url = route('password.reset', $token);
                return redirect($url);
            }


            $request->validate([
                'password' => ['required','confirmed',Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            ]);
            /*if($checkUser==0){
                session()->flash('success_msg', 'Your token has expired.');
                $url = route('password.reset', $token);
                return redirect($url);
            }*/
            User::where('remember_token',$token)->update(['password'=>Hash::make($request->password)]);
            DB::table('password_resets')->where('token', $token)->delete();
        }
        return redirect('/login');
    }

}
