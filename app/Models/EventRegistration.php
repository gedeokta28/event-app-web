<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 't_event_registration';
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'reg_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    protected $fillable = [
        'reg_id',
        'reg_date_time',
        'event_id',
        'pax_name',
        'pax_phone',
        'pax_email',
        'pax_company_name',
        'reg_success',
        'reg_ticket_no',
        'barcode_file'
    ];
}
