<?php

namespace App\Http\Controllers\Front;

use auth;
use App\Models\plan;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\recommendation;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Http\Resources\PaymentResource;

class FrontController extends Controller
{
    public function getPlan()
    {
        return PlanResource::collection(plan::get());
    }


    public function Orderpay(Request $request)
    {


        $Payment = Payment::create([
            'user_id' => $request['user_id'],
            'plan_id' => $request['plan_id'],
            'status' => 'pending',
            'transaction_id' => '0',
            'type' => 'manually'
        ]);

        return response()->json([
            "success" => true,
        ]);
    }

    public function HistroyPay(Request $request)
    {
        $Payment = Payment::where('user_id', $request['user_id'])->with('plan')->get();
        return PaymentResource::collection($Payment);

    }



    public function SelectPlan(Request $request)
    {


        $user = User::find($request->user_id)->first();
        $user->update([
            'Status_Plan' => 'pending',
            'plan_id' => $request['plan_id'],
        ]);
        $user->save();
        return $user;
        return response()->json([
            'Massage' => "The process has been completed and we are awaiting approval",
        ]);
    }

    public function Recommindation(Request $request)
    {

        $user = User::find($request->user_id)->first();
        $recommendation = recommendation::where('planes_id', $user->plan_id)->get();
        return $recommendation;

        return $recommendation;
    }

    public function UploadImagePayment(Request $request)
    {




        $header = $request->header('Authorization');
        $user=auth('api')->user();
        if(!$user){
            return response()->json([
                'Success'=>false,
                'Massage'=>"Invalid token",
            ]);
        }


         $Payment=Payment::where('user_id',$user->id)->latest()->first();

        if ($request->hasFile('img')) {
            $img = time() . '.' . $request->img->extension();
            $path = $request->img->move(public_path('ImagePayment'), $img);
        }
        $Payment->update([
            'image_payment'=>$img,
        ]);


        return response()->json([
            'Success'=>true,
            'Massage'=>"Uploaded Image",
        ]);




    }


    





}
