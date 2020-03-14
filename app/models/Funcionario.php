<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cliente';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'morada',
        'telefone',
        'veiculo',
        'email',
        'user_id'
    ];

    public function messages()
    {
        return [
            'nome.required' => 'A title is required',
        ];
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

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
    protected $dates = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function comments(){
        return $this->morphToMany('App\Comment', 'commentable');
    }*/
}
