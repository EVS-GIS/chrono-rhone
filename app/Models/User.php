<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['firstname', 'name', 'organization', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['password'];
    /**
    * Get the identifier that will be stored in the subject claim of the JWT.
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
   /**
    * Return a key value array, containing any custom claims to be added to the JWT.
    */
    public function getJWTCustomClaims()
    {
        return [
          'role' => $this->role->slug,
          'firstname' => $this->firstname,
          'name' => $this->name,
          'id' => $this->id
        ];
    }

    public function isAdmin()
    {
      if ($this->role->slug == "admin")  
      return true;
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function role()
    {
      return $this->belongsTo(Role::class);
    }

    public function events()
    {
      return $this->hasMany(Event::class);
    }
}
