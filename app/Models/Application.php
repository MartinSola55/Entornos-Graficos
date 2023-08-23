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
