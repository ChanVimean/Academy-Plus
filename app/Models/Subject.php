<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
}
