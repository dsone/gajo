<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'user_id'];

    protected $fillable = [
        'privateProfile', 'hideReleased', 'hideTBA', 'rss',
    ];

    protected $casts = [
        'privateProfile' => 'boolean',
        'hideReleased' => 'boolean',
        'hideTBA' => 'boolean',
    ];

    protected $dates = [
        'updated_at', 'created_at',
    ];

    protected $dateFormat = 'c';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
