<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDoctor
 */
class Doctor extends Model
{
    protected $fillable =
    [
        'photo',
        'phone',
        'performance',
        'cv',
        'medical_address',
        'slug',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function leads() {
        return $this->hasMany(Lead::class);
    }

    public function subscriptions() {
        return $this->belongsToMany(Subscription::class)->withTimestamps()->withPivot('expires_at');
    }

    public function specialties() {
        return $this->belongsToMany(Specialty::class);
    }

}
