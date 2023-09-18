<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'responsible_id',
        'teacher_id',
        'start_date',
        'finish_date',
        'is_finished',
        'observation',
        'description',
        'is_approved',
    ];

    public function Student()
    {
        return $this->belongsTo(Person::class, 'student_id');
    }

    public function Responsible()
    {
        return $this->belongsTo(Person::class, 'responsible_id');
    }

    public function Teacher()
    {
        return $this->belongsTo(Person::class, 'teacher_id');
    }

    public function FinalReport()
    {
        return $this->hasOne(FinalReport::class);
    }

    public function WeeklyTrackings()
    {
        return $this->hasMany(WeeklyTracking::class, 'application_id');
    }

    public function WorkPlan()
    {
        return $this->hasOne(WorkPlan::class);
    }
}
