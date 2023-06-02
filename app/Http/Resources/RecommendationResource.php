<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id'=>$this->id,
            'title'=>$this->title,
            'plans'=>$this->plans,
            'desc'=>$this->desc,
            'archive'=>$this->archive,
            'start_archive'=>$this->start_archive,
            'img'=>$this->img,
            'user_id'=>$this->user_id,
            'number_of_recived'=>$this->number_of_recived,
            'number_show'=>$this->number_show,
            'active'=>$this->active,



        ];
    }
}
