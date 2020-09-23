<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	protected static function boot() {
        parent::boot();

        static::created(function($user) {
            $options = new Option();
            while (true) {
                try {
                    $options->rss = Str::random(42);
                    $options->user_id = $user->id;
                    $options->save();
                    return;
                } catch (\Exception $e) {}
            }
        });
    }

	public function options() {
        return $this->hasOne('App\Models\Option');
    }

    public function types() {
        return $this->hasMany('App\Models\Type');
    }

    public function entries() {
        return $this->hasMany('App\Models\Entry');
    }
}
