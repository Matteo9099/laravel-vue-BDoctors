<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSubscription
 */
class Subscription extends Model
{
    protected $fillable = ["name", "price"];

    public function professionals()
    {
        return $this->belongsToMany(Professional::class)->withTimestamps()->withPivot('expires_at');
    }
}
