<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\Hrv;

class HrvController extends Controller
{
    public $successStatus = 200;

    public function store(Request $request) {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|numeric'
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to store result', 'status' => false], 401);
      }
      $user = User::find($request->user_id);
      if ($user != null) {
        $hrv = new Hrv([
          'user_id' => $user->id,
          'before' => $request->before,
          'hrv' => $request->hrv,
          'after' => $request->after
        ]);
        $hrv->save();
        return response()->json(['results' => $hrv,'message' => 'Result stored', 'status' => true], $this->successStatus);
      }
      else{
        return response()->json(['message' => 'User Not Found', 'status' => false], 402);
      }
    }

    public function hrv(Request $request) {
      $filterhrv = Hrv::orderBy('created_at')->get();
      if(!$filterhrv->isEmpty()){
        return view('welcome')->with('filterhrv',$filterhrv);
      //  return response()->json($filterbreathing, $this->successStatus);
      }
      else{
        return response()->json(['message' => 'No HRV Data', 'status' => false], 403);
      }
    }
}
