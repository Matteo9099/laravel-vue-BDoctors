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
        'professional_id',
        'email',
    ];

    public function professional() {
        return $this->belongsTo(Professional::class);
    }
}
