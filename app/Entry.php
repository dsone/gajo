<?php

namespace Gajo;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Entry extends Model {
    protected $fillable = [
        'ident_1', 'ident_2', 'release_at', 'visibility', 'type_id', 'user_id'
    ];
    protected $hidden = [
        'user_id'
    ];
    protected $dates = [
        'release_at', 'created_at', 'updated_at'
    ];

    public function type() {
        return $this->belongsTo('Gajo\Type');
    }

    public function getReleaseAtAttribute($value) {
        $c = Carbon::parse($value);
        return $c->year == 1970 ? null : $c->toIso8601ZuluString();
    }
}
