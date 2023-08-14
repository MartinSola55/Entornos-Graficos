<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'file',
        'is_accepted',
    ];

    public function Application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
