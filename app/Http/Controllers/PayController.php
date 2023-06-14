<?php

namespace App\Http\Controllers;

use DateTime;

use DateTimeZone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use App\Http\Resources\UserPlanResource;
use App\Models\plan;

class PayController extends Controller
{
    public function pending()
    {

        return UserPlanResource::collection(User::where('Status_Plan', 'pending')->with(['plan', 'imgPay' => function ($query) {
            $query->orderBy('id', 'desc')->first();
        }])->get());

    }

    public function ActivePending(Request $request)
    {



      $user=User::find($request['user_id']);
      $plan=plan::where('id',$request['plan_id'])->first();
      $start_plan = gmdate('Y-m-d');
      $end_plan = Carbon::now()->addDays(30)->format('Y-m-d');


        $user->update([
            'plan_id'=>$request->plan_id,
            'start_plan'=> $start_plan,
            'end_plan'=> $end_plan,
            'plan_me'=>$plan->name,
            'Status_Plan'=>'paid',
        ]);

          return response()->json(['Massage' =>'Res']);;
    }






}
