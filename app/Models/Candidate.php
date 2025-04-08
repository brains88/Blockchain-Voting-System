<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'party'
    ];

    /**
     * Get the votes for the candidate
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }
        return asset('images/default-candidate.png');
    }
}
