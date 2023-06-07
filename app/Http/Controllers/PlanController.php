<?php

namespace App\Http\Controllers;

use App\Models\plan;
use App\Http\Resources\PlanResource;
use App\Http\Requests\StoreplanRequest;
use App\Http\Requests\UpdateplanRequest;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public function index()
    {
        return PlanResource::collection(plan::with('telegram')->get());
    }





    public function store(StoreplanRequest $request)
    {

        $plan=plan::create($request->all());

        if ($request->has('telegram_id'))
        {
            $plan->telegram()->attach($request['telegram_id']);
        }

        return response()->json(['message' => 'Plan created successfully'], 201);


    }



    public function show($id)
    {
        $request = plan::with('telegram')->find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
          }
        return PlanResource::make($request);

    }


    public function update(StoreplanRequest $request,$id)
    {

        $requestss = plan::with('telegram')->find($id);

        if (!$requestss) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        if ($request->has('telegram_id'))
        {

            $requestss->telegram()->sync($request['telegram_id']);

        }

           $requestss->update($request->all());

        return response()->json([
            'Massage'=>"Updated Success",

        ]);
    }


    public function destroy($id)
    {

        $request = plan::find($id);
        $request->telegram()->detach();

        if (!$request)
        {
            return response()->json(['message' => 'Request not found'], 404);
        }
        $request->delete();

        return response()->json(['message' => 'Rquest is delete']);

    }
}
