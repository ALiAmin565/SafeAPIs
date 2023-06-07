<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'title'=>$this->title,
            'name'=>$this->name,
            'desc'=>$this->desc,
            'discount'=>$this->discount,
            'price'=>$this->price,
            'percentage'=>$this->percentage,
            'telegram_groups' => TelegremRsource::collection($this->whenLoaded('telegram')),

        ];
    }
}
