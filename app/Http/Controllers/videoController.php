<?php

namespace App\Http\Controllers;
use Image;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use App\Models\video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Spatie\Browsershot\Browsershot;





class videoController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //  public function __construct()
    //  {
    //      $this->middleware('auth:api'
    //     );
    //  }
    public function index()
    {
//         $jsonPayload = '{
//             "dynamicLinkInfo": {
//               "domainUriPrefix": "https://example.page.link",
//               "link": "https://www.example.com/",
//               "androidInfo": {
//                 "androidPackageName": "com.example.android"
//               },
//               "iosInfo": {
//                 "iosBundleId": "com.example.ios"
//               }
//             }
//           }';

// $test=Http::POST('https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=api_key',$jsonPayload);


        $videos=video::select('id','title','img','desc','video','created_at')->get();
        return response()->json($videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    // return response()->json(public_path('Screen_video'));




// for video
        if($request->hasFile('img')) {
            // dd(150);
            $video=time(). '.'.$request->video->extension();
           $path= $request->video->move(public_path('Videos'),$video);


        $screenshot = video::url($path)
        ->setDelay(2000) // Delay in milliseconds (optional)
        ->setWidth(1280) // Screenshot width in pixels (optional)
        ->setHeight(720) // Screenshot height in pixels (optional)
        ->screenshot();
        $screenshot->save(public_path('Videos/img'));
        dd(150);

    }








        // for image
        if($request->hasFile('img')) {
          $image=time(). '.'.$request->img->extension();
           $pathss= $request->img->move(public_path('videosthumbnails'),$image);
        }

          return response()->json(public_path('videosthumbnails/'.$image));
        // return $this->extractThumbnail($pathss);

        $videos=video::create([
            'title'=>$request['title'],
            'img'=>$image,
            'desc'=>$request['desc'],
            'name'=>11,
        ]);

        return response()->json($videos, 200,);

        // return response()->json('ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function extractThumbnail($videoPath)
{


    // $response = Http::get('POST https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=api_key
    // Content-Type: application/json

    // {
    //    "longDynamicLink": "https://example.page.link/?link=https://www.example.com/&apn=com.example.android&ibi=com.example.ios"
    // }'


//
// );

}
}
