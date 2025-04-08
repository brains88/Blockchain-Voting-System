<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'previous_hash',
        'data',
        'hash'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    /**
     * Get the formatted created_at attribute
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i:s');
    }
}
