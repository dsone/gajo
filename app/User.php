<?php

namespace Gajo;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot() {
        parent::boot();

        static::created(function($user) {
            $options = new Option();
            while (true) {
                try {
                    $options->rss = str_random(42);
                    $options->user_id = $user->id;
                    $options->save();
                    break;
                } catch (Exception $e) {}
            }
        });
    }

    public function options() {
        return $this->hasOne('Gajo\Option');
    }

    public function types() {
        return $this->hasMany('Gajo\Type');
    }

    public function entries() {
        return $this->hasMany('Gajo\Entry');
    }
}
