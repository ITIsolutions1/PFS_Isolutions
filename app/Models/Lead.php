<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'crm_id', 'source', 'status', 'assigned_to', 'notes', 'category'
    ];      

    public function crm()
    {
        return $this->belongsTo(Crm::class, 'crm_id');
    }

    // public function followUps()
    // {
    //     return $this->hasMany(FollowUp::class, 'lead_id');
    // }

    public function followUps()
{
    return $this->hasMany(FollowUp::class)->orderBy('date', 'desc');
}


    public function persona()
    {
        return $this->hasOne(CustomerPersona::class, 'crm_id', 'crm_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }



}
