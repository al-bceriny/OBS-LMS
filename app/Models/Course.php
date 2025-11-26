<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'credit',
        'department_id',
        'semester',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function offerings()
    {
        return $this->hasMany(CourseOffering::class);
    }
}
