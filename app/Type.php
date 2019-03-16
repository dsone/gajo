<?php

namespace Gajo;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {
    protected $fillable = [
        'name', 'sort', 'display', 'user_id', 'ident_1', 'ident_2'
    ];

    protected $casts = [
        'sort' => 'integer',
        'display' => 'integer',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('Gajo\User');
    }

    public function entries() {
        return $this->hasMany('Gajo\Entry');
    }
}
