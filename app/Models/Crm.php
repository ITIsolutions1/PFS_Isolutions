<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

    protected $table = 'crm';

    protected $fillable = [
        'category_id',
        'name',
        'position',  
        'company',
        'email',
        'address',
        'notes',
        'phone',
        'website',
        'qr_code',
    ];

    public function category()
{
    return $this->belongsTo(Categories::class, 'category_id');
}

    // public function persona()
    // {
    //     return $this->hasOne(CustomerPersona::class, 'crm_id');
    // }

    public function persona()
{
    return $this->hasMany(CustomerPersona::class, 'crm_id');
}


    public function leads()
    {
        return $this->hasMany(Lead::class, 'crm_id');


}

}
