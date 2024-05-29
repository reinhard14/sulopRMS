<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\Input;
use App\Models\User;


class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'submission',
        'form_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function input()
    {
        return $this->belongsTo(Input::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
