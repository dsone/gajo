<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sort', 'display', 'user_id', 'ident_1', 'ident_2',
    ];

    protected $casts = [
        'sort' => 'integer',
        'display' => 'integer',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'user_id',
    ];

    protected $dateFormat = 'c';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function entries()
    {
        return $this->hasMany('App\Models\Entry')->orderBy('ident_1');
    }
}
