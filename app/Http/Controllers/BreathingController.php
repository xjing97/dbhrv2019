<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\Breathing;
use App\Hrv;
use DB;
use Charts;

class BreathingController extends Controller
{

  public $successStatus = 200;

  public function store(Request $request) {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|numeric',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to store result', 'status' => false], 401);
    }
    $user = User::find($request->user_id);
    if ($user != null) {
      $breathing = new Breathing([
        'user_id' => $user->id,
        'before' => $request->before,
        'after' => $request->after
      ]);
      $breathing->save();
      return response()->json(['message' => 'Result stored', 'status' => true], $this->successStatus);
    }
    else{
      return response()->json(['message' => 'User Not Found', 'status' => false], 402);
    }
  }

  public function breathing(Request $request) {

    //  $filterbreathing = Breathing::orderBy('created_at')->get();
  //    $filterhrv = Hrv::orderBy('created_at')->get();

      $users = User::all();


      $chart = Charts::database($users, 'pie', 'highcharts')

                  ->title("Users Gender")

                  ->elementLabel("Total Users")

                  ->dimensions(800, 400)

                  ->responsive(true)

                  ->groupBy('gender');

      $ageRange = [];
      $ageRange[0] = DB::table('users')->where('age','<','18')->count();
      $ageRange[1] = DB::table('users')->whereBetween('age',array('18','25'))->count();
      $ageRange[2] = DB::table('users')->whereBetween('age',array('26','40'))->count();
      $ageRange[3] = DB::table('users')->whereBetween('age',array('40','60'))->count();
      $ageRange[4] = DB::table('users')->where('age','>','60')->count();


      $chartAge = Charts::create('pie', 'highcharts')

                  ->title("Users Age")

                  ->elementLabel("Total Users")

                  ->dimensions(1000, 500)

                  ->responsive(true)

                  ->labels(['<18', '18-25', '26-35','40-60','>60'])

                  ->values($ageRange);

      $filterbreathing = DB::table('breathing')
            ->join('users', 'users.id', '=', 'breathing.user_id')
            ->select('name','age','gender','height','weight','race','country','illness','breathing.created_at','before','after')
            ->orderBy('breathing.created_at','DESC')
            ->get();

      $btbefore = [];
      $btbefore[0] = DB::table('breathing')->where('before','happy')->count();
      $btbefore[1] = DB::table('breathing')->where('before','calm')->count();
      $btbefore[2] = DB::table('breathing')->where('before','sleepy')->count();
      $btbefore[3] = DB::table('breathing')->where('before','sad')->count();
      $btbefore[4] = DB::table('breathing')->where('before','angry')->count();

      $btafter = [];
      $btafter[0] = DB::table('breathing')->where('after','happy')->count();
      $btafter[1] = DB::table('breathing')->where('after','calm')->count();
      $btafter[2] = DB::table('breathing')->where('after','sleepy')->count();
      $btafter[3] = DB::table('breathing')->where('after','sad')->count();
      $btafter[4] = DB::table('breathing')->where('after','angry')->count();

      $chartBt = Charts::multi('bar', 'highcharts')

                  ->title("Breathing Training Feeling Changes")

                  ->elementLabel("Total Users")

                  ->dimensions(1000, 500)

                  ->responsive(true)

                  ->labels(['Happy', 'Calm', 'Sleepy', 'Sad', 'Angry'])
                  ->dataset('Before', $btbefore)
                  ->dataset('After',  $btafter);

      $filterhrv = DB::table('hrv')
            ->join('users', 'users.id', '=', 'hrv.user_id')
            ->select('name','age','gender','height','weight','race','country','illness','hrv.created_at','before','hrv','after')
            ->orderBy('hrv.created_at','DESC')
            ->get();

      $hrvbefore = [];
      $hrvbefore[0] = DB::table('hrv')->where('before','happy')->count();
      $hrvbefore[1] = DB::table('hrv')->where('before','calm')->count();
      $hrvbefore[2] = DB::table('hrv')->where('before','sleepy')->count();
      $hrvbefore[3] = DB::table('hrv')->where('before','sad')->count();
      $hrvbefore[4] = DB::table('hrv')->where('before','angry')->count();

      $hrvafter = [];
      $hrvafter[0] = DB::table('hrv')->where('after','happy')->count();
      $hrvafter[1] = DB::table('hrv')->where('after','calm')->count();
      $hrvafter[2] = DB::table('hrv')->where('after','sleepy')->count();
      $hrvafter[3] = DB::table('hrv')->where('after','sad')->count();
      $hrvafter[4] = DB::table('hrv')->where('after','angry')->count();

      $chartHrv = Charts::multi('bar', 'highcharts')

                  ->title("HRV Feeling Changes")

                  ->elementLabel("Total Users")

                  ->dimensions(1000, 500)

                  ->responsive(true)

                  ->labels(['Happy', 'Calm', 'Sleepy', 'Sad', 'Angry'])
                  ->dataset('Before', $hrvbefore)
                  ->dataset('After',  $hrvafter);




      return view('home', compact('chart'),compact('chartBt'))->with('chartAge',$chartAge)->with('chartHrv',$chartHrv)->with('filterbreathing',$filterbreathing)->with('filterhrv',$filterhrv);

  }

  public function chart(Request $request)
  {
    $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))

                        ->get();


    $chart = Charts::database($users, 'bar', 'highcharts')

                ->title("Monthly new Register Users")

                ->elementLabel("Total Users")

                ->dimensions(1000, 500)

                ->responsive(true)

                ->groupByMonth(date('Y'), true);

    return view('chart', compact('chart'));
  }



}
