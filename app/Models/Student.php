<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class Student extends Model
{
    protected $fillable = [
        "name",
        "student_id_number"
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
