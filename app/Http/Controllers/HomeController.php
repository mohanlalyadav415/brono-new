<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; 
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }
    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function root()
    { 
        return view('dashboard');
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }

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
                    DB::table('password_resets')->where('email',$request->email)->update(['token'=>$remember_token]);
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
            }
        }  
    }

    public function resetPassword(Request $request, $token) { 
        if($request->post()){ 
            $request->validate([
                'password' => ['required','confirmed',Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            ]);
            User::where('remember_token',$token)->update(['password'=>Hash::make($request->password)]);
            DB::table('password_resets')->where('token', $token)->delete();
        }
        return redirect('/login');
    }

}
