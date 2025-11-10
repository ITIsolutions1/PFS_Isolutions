<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPersona extends Model
{
    use HasFactory;

    protected $fillable = [
        'crm_id', 'date_of_birth', 'gender', 'occupation',
        'income_level', 'education_level', 'key_interest',
        'pain_point', 'notes'
    ];

    public function crm()
    {
        return $this->belongsTo(Crm::class);
    }
    
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
