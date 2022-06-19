<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReview
 */
class Review extends Model
{
    protected $fillable =
    [
        'title',
        'author',
        'performance',
        'vote',
        'review',
        'doctor_id',
        'email',
    ];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
}
