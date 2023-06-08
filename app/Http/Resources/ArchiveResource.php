<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'desc'=>$this->desc,
        //  'recommendtion' => UserResource::make($this->whenLoaded('user')),
            // 'telegram_groups' => RecommendationResource::collection($this->whenLoaded('recommendation')),
            'user'=>UserNameResource::make($this->whenLoaded('user'))

        ];
    }
}
