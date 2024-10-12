<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'profile_picture',
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'contact_number',
        'email',
        'username',
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function getProfilePictureAttribute($value)
    // {
    //     if ($value) {
    //         return Storage::disk('public')->url('profile_pictures/'.$value);
    //     }
    //     return null;
    // }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function hasRole($role)
    {
        return $this->role->name === $role;
    }
}



























    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

