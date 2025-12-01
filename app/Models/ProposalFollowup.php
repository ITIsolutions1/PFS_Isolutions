<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalFollowup extends Model
{
    protected $fillable = [
        'proposal_id',
        'followup_date',
        'type',
        'notes',
    ];

        protected $casts = [
        'followup_date' => 'date',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
