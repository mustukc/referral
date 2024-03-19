<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\str;
use App\Models\User;
use App\Models\Network;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Pest\Plugins\Only;

class UserController extends Controller
{

    public function loadRegister()
    {
        return view('register');
        
    }

    public function registered(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
       $referralCode = str::random(10);
       

       if(isset($request->referral_code)){

      $userData =  User::where('referral_code',$request->referral_code)->get();
     

      if(count($userData)>0){
      $user_id =  User::insertGetId([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referralCode
        ]);
        Network::insert([
            'referral_code' => $request->referral_code,
            'user_id' => $user_id,
            'parent_user_id' => $userData[0]['id'],
        ]);
      }
      else{
        return back()->with('error','Please enter valid referral code');
      }



          

       }else{
              
        User::insert([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referralCode
        ]);
       }
      
       return back()->with('success','Your Registeration has been Successfull!');


    }

    public function loadLogin(){

        return view('login');


    }
   
    public function userLogin(Request $request){
        $request->validate(
  
            [
                'email' => 'required|string|email',
                'password' => 'required',

            ]

        );
     $userData= User::where('email',$request)->get();
  
       
     $userCredential = $request->Only('email','password');
        if(Auth::attempt($userCredential)){
              return redirect('/dashboard');
        }
        else{
            return back()->with('error','user and password is incorrect!');
        }
    }
 
    public function loadDashboard(){


       
     $networkCount = Network::where('parent_user_id',Auth::user()->id)->orWhere('user_id',Auth::user()->id)->count();

    $networkData =  Network::with('user')->where('parent_user_id',Auth::user()->id)->get();
        return view('dashboard',compact('networkCount','networkData'));

    }

}
