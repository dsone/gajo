<?php

namespace Gajo;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $hidden = [ 'id', 'user_id' ];
    protected $fillable = [
        'private', 'colorblind', 'hideReleased', 'hideTBA', 'rss', 'user_id'
    ];
    protected $casts = [
        'private' => 'boolean',
        'colorblind' => 'boolean',
        'hideReleased' => 'boolean',
        'hideTBA' => 'boolean',
    ];
    
    public function user() {
        return $this->belongsTo('Gajo\User');
    }
}
