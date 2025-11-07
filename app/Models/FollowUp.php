<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'date',
        'type',
        'notes',
        'dismissable',
    ];

    public static $types = ['call', 'email', 'meeting', 'chat'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
