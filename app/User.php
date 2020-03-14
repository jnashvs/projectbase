<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
        use HasApiTokens, Notifiable;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        //'email_verified_at',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'city',
        'role_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['email_verified_at'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Task');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }
}
