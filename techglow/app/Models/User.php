<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'two_factor_secret' => 'string',
        'two_factor_recovery_codes' => 'string',
        'two_factor_confirmed_at' => 'datetime',
        'remember_token' => 'string',
        'current_team_id' => 'integer',
        'profile_photo_path' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function roles() {
        return $this->belongsToMany('App\Models\Role\Role', 'user_has_role', 'user_id', 'role_id')
            ->using('\App\Models\Role\UserHasRole');
    }

    public function hasAnyRole($roles) {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role) {
        return null !== $this->roles()->whereIn('name', $role)->first();
    }

    public function isAdministrator() {
        return $this->roles()->where('name', 'Administrator')->exists();
    }

    public function isEditor() {
        return $this->roles()->where('name', 'Editor')->exists();
    }

    public function isAuthor() {
        return $this->roles()->where('name', 'Author')->exists();
    }

    public function isPartner() {
        return $this->roles()->where('name', 'Partner')->exists();
    }

    public function isCustomer() {
        return $this->roles()->where('name', 'Customer')->exists();
    }
}
