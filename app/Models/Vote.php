<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'candidate_id'
    ];

    /**
     * Get the user that cast the vote
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the candidate that was voted for
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
