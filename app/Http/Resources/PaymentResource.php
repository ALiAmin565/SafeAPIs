<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'plan_id' => $this->plan_id,
            'image_payment' => $this->image_payment,
            'status' => $this->status,
            'plan'=>PlanNameResource::make($this->whenLoaded('plan'))
        ];
    }
}
