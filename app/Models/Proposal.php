<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'title',
        'status',
        'assign_to',
        'description',
        'submitted_at',
        'decline_reason'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function experienceDetail()
    {
        return $this->hasOne(ExperienceDetail::class, 'proposal_id');
    }

    public function files()
    {
        return $this->hasMany(ProposalFile::class);
    }

    public function followups()
{
    return $this->hasMany(ProposalFollowup::class);
}

    

}
