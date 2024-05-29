<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;


class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }
}
