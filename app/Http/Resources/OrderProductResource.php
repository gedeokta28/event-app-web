<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'salesorderno'      => $this->salesorderno,
            'stockid'           => $this->stockid,
            'stockname'         => $this->stockname,
            'stockthumb'        => $this->getStockThumbnailUrl(),
            'qtyorder'          => $this->qtyorder,
            'price'             => $this->price,
            'discountpercent'   => $this->discountpercent,
            'discountamount'    => $this->discountamount,
            'netprice'          => $this->netprice,
            'nettotal'          => $this->nettotal,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
            'stock'             => StockResource::make($this->stock)
        ];
    }
}
