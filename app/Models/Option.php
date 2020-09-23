<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

	protected $hidden = [ 'id', 'user_id' ];
    protected $fillable = [
        'private', 'colorblind', 'hideReleased', 'hideTBA', 'rss', 'user_id'
    ];
    protected $casts = [
        'private'		=> 'boolean',
        'colorblind'	=> 'boolean',
        'hideReleased'	=> 'boolean',
        'hideTBA'		=> 'boolean',
    ];
	protected $dateFormat = 'c';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
