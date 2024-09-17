<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use App\Models\Stock;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBrandResource extends JsonResource
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
            'brandid'   => $this->brandid,
            'brandname' => $this->brandname,
            'photo'     => isset($this->photo) ? asset('app/' . $this->photo) : null,
            'products'  => $this->products->map(function (Stock $stock) {
                $stock->load(['images', 'productcategory', 'productbrand']);
                return [
                    'stockid'           => $stock->stockid,
                    'stockname'         => $stock->stockname,
                    'barcode'           => $stock->barcode,
                    'brand'             => $stock->brand,
                    'brandname'         => $stock->productbrand?->brandname,
                    'categoryid'        => $stock->categoryid,
                    'categoryname'      => $stock->productcategory?->categoryname,
                    'hrg1'              => $stock->hrg1,
                    'disclist1'         => $stock->disclist1,
                    'hrg2'              => $stock->hrg2,
                    'disclist2'         => $stock->disclist2,
                    'hrg3'              => $stock->hrg3,
                    'disclist3'         => $stock->disclist3,
                    'qty1'              => $stock->qty1,
                    'unit1'             => $stock->unit1,
                    'qty2'              => $stock->qty2,
                    'unit2'             => $stock->unit2,
                    'qty3'              => $stock->qty3,
                    'unit3'             => $stock->unit3,
                    'berat'             => $stock->berat,
                    'discountinued'     => $stock->discountinued,
                    'photourl'          => $stock->photourl,
                    'images'            => $stock->images?->map(function (ProductImage $productImage) {
                        return [
                            'id'    => $productImage->id,
                            'url'   => asset('app/' . $productImage->path)
                        ];
                    })
                ];
            })
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
