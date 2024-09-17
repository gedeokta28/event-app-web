<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        activity('customers')
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log("create new customer");
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        activity('customers')
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log("update customer data");
    }

    /**
     * Handle the Customer "deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        activity('customers')
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log("delete customer data");
    }

    /**
     * Handle the Customer "restored" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        activity('customers')
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log("restore customer data");
    }

    /**
     * Handle the Customer "force deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        activity('customers')
            ->causedBy(Auth::user())
            ->performedOn($customer)
            ->log("force delete customer data");
    }
}
