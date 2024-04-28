<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foods extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'image',
        'ingredients',
        'description',
        'price',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
    
    // Relationships
   
}
