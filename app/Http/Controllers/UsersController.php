<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function login(Request $request){
      if($request->isMethod('post')){
        $data= $request->all();
        if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
          Session::put('frontSession',$data['email']);
          return redirect('/cart');
        }else {
          return redirect()->back()->with('flash_message_error','Email Adresi Veya Şifre Yanlış');
        }
      }
    }

    public function account(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
      //  echo "<pre>"; print_r($userDetails);die;

      if($request->isMethod('post')){
        $data = $request->all();

        $user = User::find($user_id);
        $user->name = $data['name'];
        $user->address = $data['address'];
        $user->city = $data['city'];
        $user->state = $data['state'];
        $user->country = $data['country'];
        $user->pincode = $data['pincode'];
        $user->mobile = $data['mobile'];
        $user->save();
        return redirect()->back()->with('flash_message_success','Başarıyla update edildi');


      }
        return view('users.account')->with(compact('userDetails'));
    }


    public function userLoginRegister(){


      return view('users.login_register');
    }

    public function logout(){
      Auth::logout();
      Session::forget('frontSession');
      return redirect('/');
    }

    public function register(Request $request){
        if ($request->isMethod('post')) {
          $data = $request->all();
        //  echo "<pre>"; print_r($data);die;
        //Check if users exist
        $userCount = User::where('email',$data['email'])->count();
        if ($userCount>0) {

          return redirect()->back()->with('flash_message_error','Bu mail adresi kullanımda');
        }else {
          $user = new User;
          $user->name = $data['name'];
          $user->email = $data['email'];
          $user->password = bcrypt($data['password']);
          $user->save();
          if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
            Session::put('frontSession',$data['email']);
            return redirect('/cart');
          }
        }
        }
      return view('users.login_register');
    }

    public function chkUserPassword(Request $request){
      $data = $request->all();
      $current_password = $data['current_pwd'];
      $user_id = Auth::User()->id;
      $check_password = User::where('id',$user_id)->first();
      if (Hash::check($current_password,$check_password->password)) {
        echo "true";die;
      }else {
        echo "false";die;
      }
    }


    public function updatePassword(Request $request){
      if($request->isMethod('post')){
        $data = $request->all();
        $old_pwd = User::where('id',Auth::User()->id)->first();
        $current_pwd = $data['current_pwd'];
        if (Hash::check($current_pwd,$old_pwd->password)) {
          $new_pwd = bcrypt($data['new_pwd']);
          User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
          return redirect()->back()->with('flash_message_success','Şifreniz Başarıyla Değiştirildi');
        }else {
          return redirect()->back()->with('flash_message_error','Yanlış Şifre');
        }
    }
    }

    public function checkEmail(Request $request){
        $data = $request->all();
      $userCount = User::where('email',$data['email'])->count();
      if ($userCount>0) {

        echo "false";
      }else {
        echo "true";die;
      }
    }
}
