<?php

namespace App\Http\Controllers\Front;

use App\Models\posts;
use App\Models\video;
use App\Models\Archive;
use App\Models\Massage;
use Illuminate\Http\Request;
use App\Models\recommendation;
use App\Http\Controllers\Controller;
use App\Http\Resources\VadioResource;
use App\Http\Resources\ArchiveResource;
use App\Http\Resources\RecommendationResource;

class TabsController extends Controller
{
    public function Videos()
    {
      return VadioResource::collection(video::get());
    }
    public function Archive()
    {
        $archives = Archive::with([
            'recommendation.target',
            'recommendation.plan2' => function ($query) {
                $query->select('id', 'name');
            }
        ])->get()->sortBy('created_at');

         $post = posts::where('status','is_post')->orderBy('created_at')->get();

        $combinedResult = collect([$archives, $post])->flatten()->sortBy('created_at')->values();

        return response()->json([
            'data' => $combinedResult
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
                // return $user->plan_id;

                    $recom = recommendation::with(['target'])
                    ->where('planes_id', $user->plan_id)
                    // ->where('archive', '0')
                    ->orderBy('created_at')
                    ->get();

                    $post = posts::where('status','is_advice','planes_id')
                    ->where('plan_id', $user->plan_id)

                    ->orderBy('created_at')
                    ->get();

                    $combinedResult = collect([$recom, $post])
                    ->flatten()
                    ->sortBy(function ($item) {
                        return strtotime($item->created_at);
                    })
                    ->values();

                    return response()->json([
                    'data' => $combinedResult
                    ]);
// }


    }

    // public function posts(Request $request)
    // {
    //                     $header = $request->header('Authorization');

    //                         $user=auth('api')->user();
    //                         if(!$user){
    //                             return response()->json([
    //                                 'Success'=>false,
    //                                 'Massage'=>"Invalid token",
    //                             ]);
    //                         }
    //                 // return $user->plan_id;

    //                     $recom = recommendation::with(['target'])
    //                     ->where('planes_id', $user->plan_id)
    //                     // ->where('archive', '0')
    //                     ->orderBy('created_at')
    //                     ->get();

    //                     $post = posts::where('status','is_advice','planes_id')
    //                     ->where('plan_id', $user->plan_id)

    //                     ->orderBy('created_at')
    //                     ->get();

    //                     $combinedResult = collect([$recom, $post])
    //                     ->flatten()
    //                     ->sortBy(function ($item) {
    //                         return strtotime($item->created_at);
    //                     })
    //                     ->values();

    //                     return response()->json([
    //                     'data' => $combinedResult
    //                     ]);
    // // }


// }


}
