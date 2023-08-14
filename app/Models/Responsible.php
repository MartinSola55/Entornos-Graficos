<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsible extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Applications()
    {
        return $this->hasMany(Application::class, 'responsible_id');
    }
}
