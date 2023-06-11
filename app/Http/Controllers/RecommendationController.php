<?php

namespace App\Http\Controllers;

use App\Models\plan;
use App\Models\tagert;
use GuzzleHttp\Client;
use App\Models\Archive;
use App\Events\recommend;
use Illuminate\Http\Request;
use App\Models\recommendation;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use App\Http\Resources\RecommendationResource;
use App\Http\Requests\StorerecommendationRequest;
use App\Http\Requests\UpdaterecommendationRequest;

class RecommendationController extends Controller
{
    public function index()
    {
        return RecommendationResource::collection(recommendation::with(['user','target'])->get());

    }


    public function store(StorerecommendationRequest $request)
    {

        $request['active'] = 1;
        $request['archive'] = 0;
        $request['img'] = $this->convertTextToImage($request->title);
        $targets = $request->input('targets');

        $test = recommendation::create($request->all());

                if (!empty($targets)) {

                    foreach ($targets as $target) {
                        $tt = tagert::create([
                            'recomondations_id' => $test['id'],
                            "target" => $target,
                        ]);
                    }
                }


        event(new recommend( response()->json([
            'test' => $test,
            'targets' => $targets
        ])));
        return 10;
        $this->telgrame($request->planes_id);


        return response()->json([
            'test' => $test,
            'targets' => $targets
        ]);


    }


    public function show($id)
    {

        $user = recommendation::find($id);

        if (!$user) {
            return response()->json(['message' => 'request not found'], 404);
        }
        return RecommendationResource::make(recommendation::with(['user','target'])->find($id));
    }


    public function update($id,StorerecommendationRequest $request)
    {

        $this->show($id);
        $this->destroy($id);
        return $this->store($request);
    }


    public function destroy($id)
    {

        $user = recommendation::find($id);
        if (!$user) {
            return response()->json(['message' => 'Recommendation not found'], 404);
        }
        $target=tagert::where('recomondations_id',$id)->get();
        $target->each->delete();
        $user->delete();


        return response()->json(['message' => 'Recommendation and associated targets deleted successfully']);

    }

    function convertTextToImage($text)
    {
        // Create a new image instance using Intervention Image
        $image = Image::canvas(100, 200);

        // Set the font properties
        // $font = $fontPath; // Path to your desired font file
        $color = '#000'; // Text color in hexadecimal format
        $x = 0; // X-coordinate for the starting position of the text
        $y = 1; // Y-coordinate for the starting position of the text
        $fontSize = 250;
        $image_Name = time() . '.' . 'jpg';
        $imagePath = public_path('Recommendation/' . $image_Name);

        // Add the text to the image
        $image->text($text, $x, $y, function ($font) use ($fontSize, $color) {
            // $font->file($fontPath);
            $font->size($fontSize);
            $font->color($color);
            $font->align('left');
            $font->valign('top');
        });

        // Save the image
        $image->save($imagePath);


        return $image_Name;
    }


    public function telgrame($text)
    {


        $plan = plan::with('telegram')->where('id', $text)->first();

        $plan->telegram->each(function ($telegram) {
            $token = $telegram->token;
            $merchant = $telegram->merchant;

            $imageUrl = 'https://th.bing.com/th/id/R.4c5f4b654d397dbf388439c146fc2a43?rik=tAXLyC2QQDAW4w&riu=http%3a%2f%2fwww.tandemconstruction.com%2fsites%2fdefault%2ffiles%2fstyles%2fproject_slider_main%2fpublic%2fimages%2fproject-images%2fIMG-Student-Union_6.jpg%3fitok%3dSIO_SJym&ehk=J7Rf60RWZAMlFREdj%2f7pdLWdGMn%2bS07tQsou0pZGgIA%3d&risl=&pid=ImgRaw&r=0';

            $response = Http::post(
                "https://api.telegram.org/bot{$token}/sendPhoto",
                [
                    'chat_id' => $merchant,
                    'photo' => $imageUrl,
                    'caption' => 'Image caption',
                ]
            );
        });

        // $imageUrl ='https://th.bing.com/th/id/R.4c5f4b654d397dbf388439c146fc2a43?rik=tAXLyC2QQDAW4w&riu=http%3a%2f%2fwww.tandemconstruction.com%2fsites%2fdefault%2ffiles%2fstyles%2fproject_slider_main%2fpublic%2fimages%2fproject-images%2fIMG-Student-Union_6.jpg%3fitok%3dSIO_SJym&ehk=J7Rf60RWZAMlFREdj%2f7pdLWdGMn%2bS07tQsou0pZGgIA%3d&risl=&pid=ImgRaw&r=0';

        // $response = Http::post(
        //     "https://api.telegram.org/bot{$token}/sendPhoto",
        //     [
        //         'chat_id' => $merchant,
        //         'photo' => $imageUrl,
        //         'caption' => 'Image caption',
        //     ]
        // );

    }

    // public function archive($id,Request $request)
    // {
    //      $rec=recommendation::find($id);
    //      if (!$rec) {
    //         return response()->json(['message' => 'request not found'], 404);
    //     }
    //      $rec->update([
    //         'archive'=>1,
    //      ]);

    //     //  return response()->json(['message' => 'The archive has been converted successfully'], 404);


    //      $archive=Archive::create([
    //          'recomondation_id'=>$id,
    //          "desc"=>$request->desc,
    //          "user_id"=>$request->user_id,

    //         ]);

    //         return $archive;
    //     }
        }
