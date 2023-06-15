<?php

namespace App\Http\Controllers\Front;

use App\Models\plan;
use App\Models\Massage;
use App\Events\ChatPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Front\MassageResource;

class ChatGroupController extends Controller
{
    public function Massage(Request $request)
    {
     $header = $request->header('Authorization');

       $user=auth('api')->user();

     if(!$user){
         return response()->json([
             'Success'=>false,
             'Massage'=>"Invalid token",
         ]);
    }
    // return Massage::with(['user','media'])->get();
    return MassageResource::collection(Massage::with(['user','media'])->where('plan_id',$user->plan_id)->get());
 }

    public function StoreMassage(Request $request)
    {

        $header = $request->header('Authorization');

        $user=auth('api')->user();

          $plan=plan::find($user->plan_id);


        $massage = Massage::create([
            'user_id' => $user->id,
            'plan_id' => $user->plan_id,
            'massage' => $request['massage'],
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('media'), $filename);

            $massage->media()->create([
                'img' => $filename,
            ]);
        }


        if ($request->hasFile('video')) {
            $image = $request->file('video');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('media'), $filename);

            $massage->media()->create([
                'video' => $filename,
            ]);
        }

        if ($request->hasFile('audio')) {
            $image = $request->file('audio');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('media'), $filename);

            $massage->media()->create([
                'audio' => $filename,
            ]);
        }

        event(new ChatPlan($massage,$plan->name));
        return response()->json([
            'success'=>true,

        ]);
    }
}
