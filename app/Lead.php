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
        'professional_id'
    ];

    public function professional() {
        return $this->belongsTo(Professional::class);
    }
}
