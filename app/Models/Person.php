<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'persons';
    
    protected $fillable = [
        'name',
        'lastname',
        'address',
        'phone',
        'file_number',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Applications()
    {
        return $this->hasMany(Application::class, 'student_id');
    }
}