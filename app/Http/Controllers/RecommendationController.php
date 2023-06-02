<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\user_id ;

use App\Events\recommend;
use Illuminate\Http\Request;
use App\Models\recommendation;
use Tymon\JWTAuth\Facades\JWTAuth;
use Intervention\Image\Facades\Image;
use App\Http\Resources\RecommendationResource;
use App\Http\Requests\StorerecommendationRequest;
use App\Http\Requests\UpdaterecommendationRequest;

 class RecommendationController extends Controller
{



//   public function __construct()
//   {
//     $this->middleware('CheckLogin');
//   }

    public function index()
    {

        // $recommendation = recommendation::with('plan')->get();

        // return $recommendation;
        $recommendation = recommendation::with(['user' =>function($e){
            $e->select('id', 'name');}])->orderBy('created_at', 'desc')->get();;
        return response()->json($recommendation);
    }


    public function store(StorerecommendationRequest $request)
    {
            $request['active']=1;
            $request['archive']=1;
            $request['img']=$this->convertTextToImage($request->desc);
            $test=recommendation::create($request->all());
            event (new recommend ($test));
            $this->telgrame($request->desc);
            return response()->json($test);
    }


    public function show($id)
    {
        $user = recommendation::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])->find($id);

        if (!$user) {
            return response()->json(['message' => 'request not found'], 404);
        }
        return response()->json($user);


    }


    public function update(UpdaterecommendationRequest $request, recommendation $recommendation)
    {

    }


    public function destroy(recommendation $id)
    {

        $user = recommendation::find($id);

        if (!$user) {
            return response()->json(['message' => 'request not found'], 404);
        }
        return response()->json($user);
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
    $fontSize=250;
    $image_Name=time(). '.' .'jpg';
    $imagePath=public_path('Recommendation/'.$image_Name);

    // Add the text to the image
    $image->text($text, $x, $y, function ($font) use ( $fontSize, $color) {
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

// function for telgram
public function telgrame($text)
{
      $token = '5941629102:AAG2H1IvZYge17doGfnzSx3oKeQ3UyCNVbc';

    $chatId = '1737873043';



    $client = new Client();
    $response =$client->get("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&text={$text}");

}
}
