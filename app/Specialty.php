<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSpecialty
 */
class Specialty extends Model
{
    protected $fillable = ['name', 'slug'];

    public function doctors() {
        return $this->belongsToMany(Doctor::class);
    }
}
