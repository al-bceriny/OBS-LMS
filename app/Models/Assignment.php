<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_offering_id',
        'title',
        'description',
        'deadline',
        'file_path',
    ];

    public function courseOffering()
    {
        return $this->belongsTo(CourseOffering::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
