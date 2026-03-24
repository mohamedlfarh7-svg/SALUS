<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name', 
        'severity', 
        'description', 
        'date_recorded', 
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}