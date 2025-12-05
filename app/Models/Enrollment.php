<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enrollment extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'enrolled_at',
    ];

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function course(): HasOne
    {
        return $this->hasOne(Course::class);
    }
}
