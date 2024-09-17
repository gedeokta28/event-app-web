<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable
{
    protected $table = 'm_user';
    public $timestamps = false;
    // Specify the custom column for username
    public function getAuthIdentifierName()
    {
        return 'user_name';  // Change this to match the actual column name for the username in your table
    }
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'user_password',
        'user_level',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
    ];

    // Use this method to get the user password field
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function getPhotoProfile(): string
    {

        if ($this->photo) {

            if (Storage::exists($this->photo)) {

                switch (config('filesystems.default')) {
                    case 'local':
                        return asset('storage/' . $this->photo);

                    case 'shared':
                        return asset('app/' . $this->photo);

                    default:
                        # code...
                        break;
                }
            }
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user_name);
    }

    public function activity(): MorphMany
    {
        return $this->MorphMany(Activity::class, 'causer');
    }
}
