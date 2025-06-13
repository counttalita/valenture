<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    /**
     * The courses that the learner is enrolled in.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrolments', 'learner_id', 'course_id')
            ->withPivot('progress');
    }
}
