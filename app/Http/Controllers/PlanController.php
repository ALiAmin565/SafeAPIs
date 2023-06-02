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

        return PlanResource::collection(plan::all());
    }





    public function store(StoreplanRequest $request)
    {
        return new PlanResource(plan::create($request->all()));
    }



    public function show($id)
    {
        $request = plan::find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        return PlanResource::make($request);

    }


    public function update(StoreplanRequest $request,$id)
    {

        $requestss = plan::find($id);


        if (!$requestss) {
            return response()->json(['message' => 'Request not found'], 404);
        }


        $requestss->update($request->all());
        return PlanResource::make($request);
    }


    public function destroy($id)
    {

        $request = plan::find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        $request->delete();

        return PlanResource::make($request);

    }
}
