<?php

namespace App\Http\Controllers;

use App\Models\Archive;


use App\Http\Resources\ArchiveResource;
use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $archive = Archive::with('recommendation','user')->get();
        // return PlanResource::collection(plan::with('telegram')->get());
        // return Archive::with('user')->get();
        return   ArchiveResource::collection(Archive::with('user')->get());
    }


    public function store(StoreArchiveRequest $request)
    {
        return response()->json(Archive::create($request->all()));
    }


    public function show($id)
    {
        $request = Archive::with(['recommendation:id,img,title', 'user:id,email'])->find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        return response()->json($request);
    }



    public function update(UpdateArchiveRequest $request,$id)
    {
           $archive=Archive::find($id);
           if (!$archive) {
            return response()->json(['message' => 'Request not found'], 404);
        }
            $archive->update($request->all());

            return $this->show($archive);

    }


    public function destroy($id)
    {
        $archive=Archive::find($id);
        if (!$archive) {
         return response()->json(['message' => 'Request not found'], 404);
     }
        $archive->delete();
        return response()->json(['message' => 'Deleted successfully']);


    }
}
