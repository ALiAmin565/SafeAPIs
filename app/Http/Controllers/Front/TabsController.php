<?php

namespace App\Http\Controllers\Front;

use App\Models\video;
use App\Models\Archive;
use Illuminate\Http\Request;
use App\Models\recommendation;
use App\Http\Controllers\Controller;
use App\Http\Resources\VadioResource;
use App\Http\Resources\ArchiveResource;
use App\Http\Resources\RecommendationResource;
use App\Models\posts;

class TabsController extends Controller
{
    public function Videos()
    {
      return VadioResource::collection(video::get());
    }
    public function Archive()
    {
// return 150;
        $archives = Archive::with([
            'recommendation.target',
            'recommendation.plan2' => function ($query) {
                $query->select('id', 'name');
            }
        ])->get();
          $post=posts::get();

        $archives->each(function ($archive) {
            $archive->recommendation->target->makeHidden(['id','recomondations_id']);
        });
         $combinedResult = collect([$archives, $post])->flatten()->sortBy('created_at');
        return response()->json([
            'data'=>$combinedResult
        ]);
    }

    public function Advice(Request $request)
    {

        $header = $request->header('Authorization');

        $user=auth('api')->user();
        if(!$user){
            return response()->json([
                'Success'=>false,
                'Massage'=>"Invalid token",
            ]);
        }


        $recom=RecommendationResource::collection(recommendation::with(['target'])->where([
            'planes_id'=>$user->plan_id,
            // 'archive'=>'0'
        ])->get());

         $post=posts::where('plan_id',$user->plan_id)->get();
        $combinedResult = collect([$recom, $post])->flatten()->sortBy('created_at')->values();

        return response()->json([
            'data'=>$combinedResult
        ]);


    }

    // public function posts(Request $request)
    // {

    //     $header = $request->header('Authorization');

    //     $user=auth('api')->user();
    //     if(!$user){
    //         return response()->json([
    //             'Success'=>false,
    //             'Massage'=>"Invalid token",
    //         ]);
    //     }


    //     $recom=RecommendationResource::collection(recommendation::with(['target'])->where([
    //         'planes_id'=>$user->plan_id,
    //         // 'archive'=>'0'
    //     ])->get());

    //     $post=posts::get();
    //     $combinedResult = collect([$recom, $post])->flatten()->sortBy('created_at')->values();

    //     return response()->json([
    //         'data'=>$combinedResult
    //     ]);


    // }


}
