<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserPlanResource;

class PayController extends Controller
{
    public function pending()
    {

        return UserPlanResource::collection(User::where('Status_Plan', 'pending')->with(['plan', 'imgPay' => function ($query) {
            $query->orderBy('id', 'desc')->first();
        }])->get());

    }
}
