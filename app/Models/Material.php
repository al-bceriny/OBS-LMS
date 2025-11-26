<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_offering_id',
        'title',
        'description',
        'file_path',
        'visible_from',
    ];

    public function courseOffering()
    {
        return $this->belongsTo(CourseOffering::class);
    }
}
