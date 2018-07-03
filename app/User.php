<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'trial_ends_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    public function isAdmin()
    {
        return $this->role == 1 ? true : false;
    }
}
