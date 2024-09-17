<?php

namespace App\Observers;

use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class StockObserver
{
    /**
     * Handle the Stock "created" event.
     *
     * @param  \App\Models\Stock  $stock
     * @return void
     */
    public function created(Stock $stock)
    {
        activity('stock')
            ->causedBy(Auth::user())
            ->performedOn($stock)
            ->log("create new stok");
    }

    /**
     * Handle the Stock "updated" event.
     *
     * @param  \App\Models\Stock  $stock
     * @return void
     */
    public function updated(Stock $stock)
    {
        activity('stock')
            ->causedBy(Auth::user())
            ->performedOn($stock)
            ->log("update stock data");
    }

    /**
     * Handle the Stock "deleted" event.
     *
     * @param  \App\Models\Stock  $stock
     * @return void
     */
    public function deleted(Stock $stock)
    {
        activity('stock')
            ->causedBy(Auth::user())
            ->performedOn($stock)
            ->log("delete stock data");
    }

    /**
     * Handle the Stock "restored" event.
     *
     * @param  \App\Models\Stock  $stock
     * @return void
     */
    public function restored(Stock $stock)
    {
        activity('stock')
            ->causedBy(Auth::user())
            ->performedOn($stock)
            ->log("restore stock data");
    }

    /**
     * Handle the Stock "force deleted" event.
     *
     * @param  \App\Models\Stock  $stock
     * @return void
     */
    public function forceDeleted(Stock $stock)
    {
        activity('stock')
            ->causedBy(Auth::user())
            ->performedOn($stock)
            ->log("force delete stock data");
    }
}
