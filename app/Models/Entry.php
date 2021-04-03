<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entry extends Model
{
    use HasFactory;

	protected $fillable = [
        'ident_1', 'ident_2', 'release_at', 'visibility', 'type_id', 'user_id'
    ];
    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];
    protected $dates = [
        'release_at', 'created_at', 'updated_at'
    ];
	protected $dateFormat = 'c';

    public function type() {
        return $this->belongsTo('App\Models\Type');
    }

    public function getReleaseAtAttribute($value) {
        $c = Carbon::parse($value);
        return $value == null ? null : $c->format('c');
    }

	public function setReleaseAtAttribute($date)
	{
		$this->attributes['release_at'] = empty($date) ? null : Carbon::parse($date)->format('c');
	}
}
