<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSubscription
 */
class Subscription extends Model
{
    protected $fillable = ["name", "price"];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class)->withTimestamps()->withPivot('expires_at');
    }
}
