<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User  extends Authenticatable implements JWTSubject

{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='users';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'type',
        'created_at',
        'updated_at',
    ];




    public function scopeSelection($q)
    {
     return $q->select([
         'id',
         'name',
         'email',
         'password',
         'phone',
         'type',
         'created_at',
         'updated_at',
     ])  ;

    }

// Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
