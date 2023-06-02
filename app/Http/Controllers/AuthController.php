<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\OtpMail;
use App\Mail\ResetPasswordOtp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','create','checkOtp','me','sendOtp','reSendOtp','resetPassword','dymnamikeLink']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function create(Request $request){
        $validator =Validator::make($request->all(),
            [
            'name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:8',
            'phone'=>'required',
            //  'comming_afflite'=>'required|exists:users,affiliate_code',

            ]);



        if ($validator -> fails()) {
            // return json of errors object
            $response = [
                'success' => false,
                "errors"=>$validator->errors()
              ];
            return response()->json( $response,200);
            }




        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],

            'comming_afflite'=>$request['comming_afflite'],
            'password' => Hash::make($request['password']),
        ]);
        $this->verifyEmail($request);

        return $this->login($request);


    }
    public function sendOtp(Request $request)
    {
        // Retrieve the user's email address from the request
        $email = $request->input('email');

        // Check if the email address exists in the database
        $user = User::where('email', $email)->count();
        // check if email is exist

        if ($user==0) {
            // Email not found
            $response = [
                'success' => false,
                'message' => 'Email is not exist'
            ];
            return response()->json($response);





        }
        $user = User::where('email', $email)->first();


        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store the OTP in the database for the user
        $user->otp = $otp;
        $user->save();
        $otpDataa = [

            'otp' => $otp,
            'subject'=>"reset Password"

        ];
        // Send the OTP to the user's email address
        Mail::to($email)->send(new ResetPasswordOtp($otpDataa)); // Replace with your own mail class

        // Return a success response
        $response = [
            'success' => true,
            'message' => 'OTP sent successfully'
        ];
        return response()->json($response);
    }
    // cheackopt
        public function checkOtp(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $user = User::where('email', $email)->first();
        $userOtp=$user->otp;


        if ($otp==$userOtp) {
            if($request['action']!="reset"){
            $user->otp=null;
            $user->verified=true;
            $user->affiliate_code=  $this->generate_affiliate_code();
            $user->email_verified_at=time();
            $user->affiliate_link=$this->dymnamikeLink();

            $user->save();
            $user2=User::where('affiliate_code', $user->comming_afflite)->first();
            $user2->number_of_user= $user2->number_of_user +1;
            $user2->save();


            }



            $response = [
                'success' => true,
                'message' => 'OTP is valid'
            ];
        } else {
            // OTP is not valid for the given user
            $response = [
                'success' => false,
                'message' => 'Invalid OTP'
            ];
        }

        return response()->json($response);
    }
    public function resetPassword(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['success' => false,
            'message' => 'Email address not found'], 200);
        }
        $userOtp=$user->otp;


        if ($otp=$userOtp) {
            if($request['action']=="reset"){
            $user->otp=null;
            $user->password=Hash::make($request['password']);
            $user->save();

            }
            $response = [
                'success' => true,
                'message' => 'Password Changed successfully'
            ];
        } else {
            // OTP is not valid for the given user
            $response = [
                'success' => false,
                'message' => 'Invalid OTP'
            ];
        }

        return response()->json($response);
    }
    function generate_affiliate_code()
    {
        $code = '';
        $chars = array_merge(range('A', 'Z'), range(0, 9));

        // Generate a code with 8 characters
        for ($i = 0; $i < 8; $i++) {
            $code .= $chars[array_rand($chars)];
        }

        // Check if the code already exists in the database
        $existing_users = User::where('affiliate_code', $code)->count();
        if ($existing_users > 0) {
            // If it does, generate a new one recursively
            return $this->generate_affiliate_code();
        }

        return $code;
    }
    public function login(Request $data)
    {
        $validator =Validator::make($data->all(),
            [
                'email'=>'required|email:rfc,dns',
                'password'=>'required|min:8',
            ]);

        if ($validator -> fails()) {
            // return json of errors object
            $response = [
                'success' => false,
                "errors"=>$validator->errors()
              ];
            return response()->json( $response,200);



        }
        $userO=User::where('email',$data['email'])->count();
        if($userO == 0){
            return response()->json([                'success' => false,
            'message' => 'Email address not Exist'], 200);
        }
        $credentials = $data->only(['email', 'password'],400);
        $token = auth('api')->attempt($credentials);


        if (! $token) {
            return response()->json([                'success' => false,
            'message' => 'Wrong Password'], 200);
        }
        $user=auth('api')->user();
        $user->token=$token;

        return response()->json([
            'success' => true,

            'user' => $user]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $header = $request->header('Authorization');





        $user=auth('api')->user();
        if(!$user){
            return response()->json(['success' => false,
            'message' => 'invalid token'], 200);
        }
        $user->token=$header;
        return response()->json([
            'success' => true,
            "user"=>$user]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function verifyEmail(Request $data){
        // generate otp from 6 digits
        $otp = rand(100000, 999999);
        // send it to database
        try{
            $user = User::where('email', $data['email'])->firstOrFail();
            $user->otp = $otp;
            $user->save();
            // send Mail Otp
            $otpDataa = [
                'otp' => $otp,
                'subject'=>"Verify Email"
            ];
            Mail::to($data['email'])->send( new OtpMail($otpDataa));

            return response()->json(['success' => true, 'message' => "OTP sent to email"]);

        }catch (\Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

    }
    public function reSendOtp(Request $data){
        // generate otp from 6 digits
        $email=$data['email'];
        // send it to database
        try{
            $user = User::where('email', $email)->firstOrFail();

            // Then, retrieve the OTP from the user's record
            if(!$user){

            return response()->json(['success' => false, 'message' => "Email not found"]);

            }
            $otp = $user->otp;
            // send Mail Otp
            $otpDataaa = [

                'otp' => $otp,
                'subject'=>"Verify Email"


            ];

            Mail::to($data['email'])->send( new OtpMail($otpDataaa));




            return response()->json(['success' => true, 'message' => "OTP sent to email"]);

        }catch (\Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */



    //  for plus number of user

    public function number_user($affiliate_code)
    {
        $user=User::where('affiliate_code',$affiliate_code)->first();



    $add= $user->number_of_user +1;
        $user->update(
            [
                'number_of_user'=>$add
            ]
        );



    }


    public function dymnamikeLink()
    {

        
         
        $jsonData = [
            'dynamicLinkInfo' => [
                'domainUriPrefix' => 'https://smart123.page.link',
                'link' => 'https://smartsolution-ar.com/?code=futfu',
                'androidInfo' => [
                    'androidPackageName' => 'com.example.safe',
                ],
                'iosInfo' => [
                    'iosBundleId' => 'com.example.safe',
                ],
                
            ],
        ];


$response=Http::post('https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=AIzaSyCn_tqOc5ZxBvlOmBCXuVnp-yZ2sUD3qH8'
,$jsonData);

$data=json_decode($response);
return $data->shortLink;
    

     
    }
}
