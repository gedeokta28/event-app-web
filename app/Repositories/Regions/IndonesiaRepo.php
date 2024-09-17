<?php

namespace App\Repositories\Regions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IndonesiaRepo
{

    /**
     * API Wilayah Indonesia
     *
     * @var string
     */
    private $apiSources = 'https://www.emsifa.com/api-wilayah-indonesia/api/';

    public function getIndonesiaProvince(): array
    {
        $result = Cache::remember("provinces", now()->addDay(), function () {
            $res = Http::get($this->apiSources . '/provinces.json');
            return $res->json();
        });

        $provincesMapped = array_map(function ($item) {
            $item['name'] = ucwords(strtolower($item['name']));
            return $item;
        }, $result);

        return $provincesMapped;
    }
}
