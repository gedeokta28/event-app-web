<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionNotificationResource extends JsonResource
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
            'data' => [
                'order_id'      => $this->data['order_id'],
                'order_status'  => $this->data['order_status'],
                'message'       => $this->data['message']
            ],
            'read_at' => $this->read_at?->toIsoString(),
            'created_at' => $this->created_at?->toIsoString()
        ];
    }
}
