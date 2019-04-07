<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class PassportController extends Controller
{
  public $successStatus = 200;
  /**
   * login api
   *
   * @return \Illuminate\Http\Response
   */
   public function login(Request $request)
   {
      $validator = Validator::make($request->all(), [
          'email' => 'required|string|email',
          'password' => 'required|string|min:6|max:8',
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Email Or Password', 'status' => false], 401);
      }
      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
          $user = Auth::user();
          if ($user->tokens->count() > 0) {
            $user->tokens()->delete();
          }
          $token =  $user->createToken('MyApp')->accessToken;
          //$success['token'] =  $user->createToken('MyApp')->accessToken;
          $user_id =  $user->id;
          //return response()->json(['success'=>$success, 'message' => 'Login Successfully', 'status' => true], $this->successStatus);
          return response()->json(['accessToken' => $token, 'id' => $user_id,'message' => 'Login Successfully', 'status' => true], $this->successStatus);
      }
      else{
          return response()->json(['error'=>'Wrong Email Or Password', 'message' => 'Invalid Email Or Password', 'status' => false], 401);
      }
    }

  /**
   * Register api
   *
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'name' => 'required|string',
          'email' => 'required|string|email|unique:users',
          'password' => 'required|string|min:6|max:8',
          'c_password' => 'required|same:password',
          'age' => 'required|numeric',
          'gender' => 'required|string',
          'height' => 'required|numeric',
          'weight' => 'required|numeric',
          'race' => 'required|string|max:255',
          'illness' => 'max:255'
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors(), 'message' => 'Failed To Register User', 'status' => false], 401);
      }
      $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'height' => $request->height,
            'weight' => $request->weight,
            'race' => $request->race,
            'country' => $request->country,
            'illness' => $request->illness,
      ]);
      $user->save();
      return response()->json(['message' => 'User Registered Successfully', 'status' => true], $this->successStatus);
  }

  /**
   * details api
   *
   * @return \Illuminate\Http\Response
   */

  public function logout(Request $request) {
    $user = Auth::user()->token()->delete();
    return response()->json(['message' => 'Logged Out Successfully'], $this->successStatus);
  }

  public function user(Request $request) {
    return response()->json(Auth::User(), $this->successStatus);
  }

  public function resetPassword(Request $request) {

    $validator = Validator::make($request->all(), [
       'email' => 'required|string|email',
   ]);
   if ($validator->fails()) {
       return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Email', 'status' => false], 401);
   }
    $user = User::where('email', $request->email)->first();
   // if ($user != null) {
     $user->password = bcrypt(str_random(6));
     //$user->delete();
     // $user = new User([
     //     'name' => $user->name,
     //     'email' => $request->email,
     //     'age' => $user->age,
     //     'gender' => $user->gender,
     //     'country' => $user->country,
     //     'race' => $user->race,
     //     'height' => $user->height,
     //     'weight' => $user->weight,
     //     'illness' => $user->illness,
     //     'password' => bcrypt($newPass)
     //   ]);
     $user->save();


    // $validator = Validator::make($request->all(), [
    //     'email' => 'required|string|email',
    // ]);
    // if ($validator->fails()) {
    //     return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Email', 'status' => false], 401);
    // }
    // $user = User::where('email', $request->email)->first();
    // if ($user != null) {
    //   $newUser = $user->name;
    //   $newAge = $user->age;
    //   $newGender = $user->gender;
    //   $newHeight = $user->height;
    //   $newWeight = $user->weight;
    //   $newRace = $user->race;
    //   $newCountry = $user->country;
    //   $newIllness = $user->illness;
    //
    //
    //   $newPass = str_random(6);
    //
    //   $user->delete();
    //   $user = new User([
    //       'name' => $newUser,
    //       'email' => $request->email,
    //       'password' => bcrypt($newPass),
    //       'age' => $newAge,
    //       'gender' => $newGender,
    //       'height' => $newHeight,
    //       'weight' => $newWeight,
    //       'race' => $newRace,
    //       'country' => $newCountry,
    //       'illness' => $newIllness,
    //
    //     ]);
    //   $user->save();
      // try{
      //   Mail::to($user)->send(new ResetPassword($request->email, $newPass));
      // }
      // catch(Exception $e){
      //   return response()->json(['message' => 'Failed To Send Email To User', 'status' => false], 402);
      // }
    //   return response()->json(['message' => 'User Password Reset Successfully. Please check your email.', 'status' => true], $this->successStatus);
    // }
    //else{
      return response()->json(['message' => 'Email is not registered', 'status' => false], 402);
    //}

  }

  public function changePassword(Request $request) {
    $validator = Validator::make($request->all(), [
        'oldPassword' => 'required|string|min:6|max:8',
        'newPassword' => 'required|string|min:6|max:8',
        'c_newPassword' => 'required|same:newPassword'
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Input', 'status' => false], 401);
    }
      $user = Auth::User();
    if(Hash::check($request->oldPassword, $user->password)) {
        $user->password = bcrypt($request->newPassword);
        $user->save();
        $user->token()->delete();
      return response()->json(['message' => 'User Password Updated Successfully', 'status' => true], $this->successStatus);
    }
    else {
      return response()->json(['message' => 'Incorrect Old Password', 'status' => false], 402);
    }
  }
}
