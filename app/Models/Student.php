<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use App\Models\Subject;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        'class_name'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function subjects()
{
    return $this->belongsToMany(Subject::class, 'enrollments');
}
}
