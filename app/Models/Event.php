<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;

    protected $table = 'm_event';
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'event_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    protected $fillable = [
        'event_id',
        'event_name',
        'event_start_date',
        'event_end_date',
        'event_location',
        'event_time',
        'logo_file',
        'intro_file',
        'ticket_file',
        'event_description',
        'event_active',
        'event_code_reg',
        'event_code_trans',
        'event_max_pax',
        'slug',
    ];
}
