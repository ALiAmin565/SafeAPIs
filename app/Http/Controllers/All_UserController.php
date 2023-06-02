<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\ChekRequestUser;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\updatedUserRequest;
 use Illuminate\Database\Eloquent\SoftDeletes;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\Validator;


class All_UserController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return '    نعم يستا قولتلك روح ع get user';

     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // return $request;

        $user=User::create($request->all());
         return response()->json([
            'state'=>'success add',
            'user'=>$user,
         ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $request = User::find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        return UserResource::make($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updatedUserRequest $request, $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Request not found'], 404);
        }
       $store=$user->update($request->all());

       return [
        'state'=>'success update',
        'user'=>UserResource::make($user),
       ];




    }


    public function destroy($id)
    {

        // not forget soft delete
        $request = User::find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $request->delete();
    }


    public function get_user($request)
    {

    if($request == 'user')
    {
        return UserResource::collection(User::where('state',$request)->get());

    }if($request == 'admin')
    {
        return UserResource::collection(User::where('state',$request)->get());

    }
    if($request == 'super_admin')
    {
        return UserResource::collection(User::where('state',$request)->get());

    }



     }

     public function serach($query)
     {
        $results = User::where('name', 'like', '%' . $query . '%')->orWhere('email','like','%'.$query .'%')
        ->get();
        return response()->json($results);
     }
        // for get allUser
     public function get_all_subscrib($comming_afflite)
     {
        $results = User::select('id','name')->where('comming_afflite',$comming_afflite)->get();

        if (!$results) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        return response()->json($results);
     }
}
