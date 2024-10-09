<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'm_user_event';

    // Specify the primary key if it's not 'id' (optional in this case)
    protected $primaryKey = 'id';

    // Indicate that the primary key is auto-incrementing
    public $incrementing = true;

    // Define the data types for your fields
    protected $keyType = 'int';

    // Disable timestamps if the table does not have them
    public $timestamps = false;

    // Specify fillable fields
    protected $fillable = ['user_id', 'event_id'];
}
