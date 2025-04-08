<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'wallet_address',
        'nonce',
        'name',
        'email',
        'password',
        'is_verified',
        'has_voted',
        'auth_message',
        'role',
    ];
    
    // Generate new nonce
    public function generateNonce()
    {
        $this->nonce = Str::random(32);
        $this->save();
        return $this->nonce;
    }


}
