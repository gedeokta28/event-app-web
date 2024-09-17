<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $this->load(['productbrand', 'productcategory', 'images', 'variantOption']);
        return [
            'variant_stockid'   => $this->variant_stockid,
            'stockid'           => $this->stockid,
            'stockname'         => $this->stockname,
            'barcode'           => $this->barcode,
            'hrg1'              => $this->hrg1,
            'disclist1'         => $this->disclist1,
            'hrg2'              => $this->hrg2,
            'disclist2'         => $this->disclist2,
            'hrg3'              => $this->hrg3,
            'disclist3'         => $this->disclist3,
            'qty1'              => $this->qty1,
            'unit1'             => $this->unit1,
            'qty2'              => $this->qty2,
            'unit2'             => $this->unit2,
            'qty3'              => $this->qty3,
            'unit3'             => $this->unit3,
            'berat'             => $this->berat,
            'discountinued'     => $this->discountinued,
            'photourl'          => $this->photourl ? asset('app/' . $this->photourl) : null,
            'stockdescription'  => $this->stockdescription,
            'images'            => $this->images->map(function (ProductImage $productImage) {
                return [
                    'id'    => $productImage->id,
                    'url'   => asset('app/' . $productImage->path)
                ];
            }),
            'brand'             => [
                'brandid'       => $this->brandid,
                'brandname'     => $this->productbrand?->brandname,
                'brandimage'    => $this->productbrand?->photo ? asset('app/' . $this->productbrand?->photo) : null
            ],
            'category'          => [
                'categoryid'    => $this->categoryid,
                'categoryname'  => $this->productcategory?->categoryname,
                'categoryimage' => $this->productcategory?->photo ? asset('app/' . $this->productcategory?->photo) : null
            ],
            'variant_option'    => $this->variantOption?->only('optionid', 'name')
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
