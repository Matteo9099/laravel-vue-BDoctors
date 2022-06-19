<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLead
 */
class Lead extends Model
{
    protected $fillable = 
    [
        'author',
        'email',
        'message',
        'doctor_id'
    ];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
}
