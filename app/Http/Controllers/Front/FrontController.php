<?php

namespace App\Http\Controllers\Front;

use App\Models\plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;

class FrontController extends Controller
{
    public function getPlan()
    {
        return PlanResource::collection(plan::get());

    }

    public function SelectPlan(Request $request)
    {


        $user=User::find($request->user_id)->first();

        $user->update([
            'Status_Plan'=>'pending',
            'plan_id'=>$request['plan_id'],
        ]);
        $user->save();
        return $user;
        return response()->json([
            'Massage'=>"The process has been completed and we are awaiting approval",
        ]);
    }
}
