<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'salesorderno'          => $this->salesorderno,
            'notes'                 => $this->notes,
            'salesorderdate'        => $this->salesorderdate,
            'customerid'            => $this->customerid,
            'paymentype'            => $this->paymentype,
            'salespersonid'         => $this->salespersonid,
            'salesordergrandtotal'  => $this->salesordergrandtotal,
            'dpp'                   => $this->dpp,
            'ppn'                   => $this->ppn,
            'ppnpercent'            => $this->ppnpercent,
            'deliveryto'            => $this->deliveryto,
            'deliveryaddress'       => $this->deliveryaddress,
            'deliveryphone'         => $this->deliveryphone,
            'salesordertime'        => $this->salesordertime,
            'status'                => $this->status,
            'processdate'           => $this->processdate,
            'processtime'           => $this->processtime,
            'processorderno'        => $this->processorderno,
            'shipping_fee'          => $this->shipping_fee,
            'products'              => OrderProductCollection::make($this->salesOrderDetails),
            'created_user_id'       => $this->created_user_id,
            'customer'              => CustomerResource::make($this->customer)->minimal(),
            'created_user'          => $this->createdUser ? CustomerResource::make($this->createdUser)->minimal() : null
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status'    => 'success',
            'message'   => ''
        ];
    }
}
