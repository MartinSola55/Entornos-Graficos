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
        'pps_id',
        'finish_date',
        'is_finished',
        'observation',
    ];

    public function Student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function Responsible()
    {
        return $this->belongsTo(Responsible::class, 'responsible_id');
    }

    public function Teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function Pps()
    {
        return $this->belongsTo(Pps::class, 'pps_id');
    }

    public function FinalReports()
    {
        return $this->hasMany(FinalReport::class, 'application_id');
    }

    public function WeeklyTrackings()
    {
        return $this->hasMany(WeeklyTracking::class, 'application_id');
    }

    public function WorkPlans()
    {
        return $this->hasMany(WorkPlan::class, 'application_id');
    }
}
