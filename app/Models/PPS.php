<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PPS extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description',
    ];

    public function Applications()
    {
        return $this->hasMany(Application::class, 'pps_id');
    }
}
