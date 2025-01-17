<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;  // Ensure this import is present

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['name', 'email', 'password'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Returns the primary key (usually 'id') of the user
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];  // Return any custom claims you want in the JWT token (leave empty if none)
    }
}
