<?php

namespace App\Helpers;

use App\Models\Stock;

class StockHelper
{

    const BEST_SELLER = 'best-seller';

    public static function basePrice(Stock $stock, int $qty): float
    {

        if (
            $stock->qty3 != 0 &&
            $stock->disclist3 &&
            $qty >= $stock->qty3
        ) {
            return $stock->hrg3;
        }

        if (
            $stock->qty2 != 0 &&
            $stock->disclist2 &&
            $qty >= $stock->qty2 &&
            $qty < $stock->qty3
        ) {
            return $stock->hrg2;
        }

        if (
            $stock->qty1 != 0 &&
            $stock->disclist1 &&
            $qty >= $stock->qty1 &&
            $qty < $stock->qty2
        ) {
            return $stock->hrg1;
        }

        // default value
        return $stock->hrg1;
    }

    public static function groceryPrice(Stock $stock, int $qty): float
    {

        if (($qty >= ($stock->qty3 ?? 0)) && (($stock->qty3 ?? 0) != 0)) {
            return $stock->hrg1 - ($stock->hrg1 * ($stock->disclist3 / 100));
        }

        if (($qty >= ($stock->qty2 ?? 0)) && (($stock->qty2 ?? 0) != 0)) {
            return $stock->hrg1 - ($stock->hrg1 * ($stock->disclist2 / 100));
        }

        if (($qty >= ($stock->qty1 ?? 0)) && (($stock->qty1 ?? 0) != 0)) {
            return $stock->hrg1 - ($stock->hrg1 * ($stock->disclist1 / 100));
        }

        // default value
        return $stock->hrg1;
    }

    public static function groceryDiscountPercentage(Stock $stock, int $qty): float
    {
        if (($qty >= ($stock->qty3 ?? 0)) && (($stock->qty3 ?? 0) != 0)) {
            return $stock->disclist3;
        }

        if (($qty >= ($stock->qty2 ?? 0)) && (($stock->qty2 ?? 0) != 0)) {
            return $stock->disclist2;
        }

        if (($qty >= ($stock->qty1 ?? 0)) && (($stock->qty1 ?? 0) != 0)) {
            return $stock->disclist1;
        }

        // default value
        return 0;
    }

    public static function groceryDiscountAmount(Stock $stock, int $qty): float
    {
        if (($qty >= ($stock->qty3 ?? 0)) && (($stock->qty3 ?? 0) != 0)) {
            return $stock->hrg1 * ($stock->disclist3 / 100);
        }

        if (($qty >= ($stock->qty2 ?? 0)) && (($stock->qty2 ?? 0) != 0)) {
            return $stock->hrg1 * ($stock->disclist2 / 100);
        }

        if (($qty >= ($stock->qty1 ?? 0)) && (($stock->qty1 ?? 0) != 0)) {
            return $stock->hrg1 * ($stock->disclist1 / 100);
        }

        // default value
        return 0;
    }
}
