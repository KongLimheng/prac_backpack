<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['UserFullName', 'Salutation'];

    public function contact()
    {
        return $this->hasOne(Contacts::class, 'user_id_fk');
    }

    public function getUserFullNameAttribute()
    {
        return $this->salutation .' '. $this->first_name. ' '. $this->last_name;
    }
  
    public function getSalutationAttribute()
    {
        return optional($this->contact)->salutation;
    }
    public function getFirstNameAttribute()
    {
        return optional($this->contact)->first_name;
    }
    public function getLastNameAttribute()
    {
        return optional($this->contact)->last_name;
    }
    public function getProfileUserAttribute()
    {
        return optional($this->contact)->profile;
    }
}
