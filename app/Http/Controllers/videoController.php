<?php

namespace App\Http\Controllers;

use App\Models\video;
use Illuminate\Http\Request;
use App\Http\Resources\VadioResource;


class videoController extends Controller
{

    public function index()
    {

        return  VadioResource::collection(video::get());

    }

  
    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        //for img
            if($request->hasFile('img')) {
                $img=time(). '.'.$request->img->extension();
                $path= $request->img->move(public_path('videosthumbnails'),$img);
            }

        // for Video
        if($request->hasFile('video')) {
          $video=time(). '.'.$request->video->extension();
           $pathss= $request->video->move(public_path('Videos'),$video);
        }


        $videos=video::create([
            'title'=>$request['title'],
            'img'=>$img,
            'desc'=>$request['desc'],
            'video'=>$video,
        ]);

        return response()->json([
            'Massage'=>"Request is Sucess",
        ]);


    }


    public function show($id)
    {

        return  VadioResource::make(video::find($id));
    }


    public function edit($id)
    {
        return  VadioResource::collection(video::find($id));

    }


    public function update(Request $request, $id)
    {


        $check = video::find($id);

        if (!$check) {
            return response()->json(['message' => 'Request not found'], 404);
        }

            if($request->hasFile('img')) {
                $img=time(). '.'.$request->img->extension();
                $path= $request->img->move(public_path('videosthumbnails'),$img);
            }else{
                $img=$check->img;
            }


            if($request->hasFile('video')) {
            $video=time(). '.'.$request->video->extension();
            $pathss= $request->video->move(public_path('Videos'),$video);
            }else{
                $video=$check->video;
            }

            $check->update([

                'img'=>$img,
                'desc'=>$request['desc'],
                'video'=>$video,
                'title'=>$request->title,
            ]);

            return response()->json([
                'Massage'=>"Request is Updated",
            ]);


    }


    public function destroy($id)
    {
        $check = video::find($id);

        if (!$check) {
            return response()->json(['message' => 'Request not found'], 404);
        }
         $image_path =public_path('videosthumbnails/'.$check->img);  // Value is not URL but directory file path
        if(file_exists($image_path)) {
            @unlink($image_path);
        }
        $check->delete();
        return response()->json(['message' => 'Request is delete']);
    }




}
