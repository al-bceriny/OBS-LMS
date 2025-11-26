<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_offering_id',
        'title',
        'type',
        'start_time',
        'end_time',
        'file_path',
        'description',
    ];

    public function courseOffering()
    {
        return $this->belongsTo(CourseOffering::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}
