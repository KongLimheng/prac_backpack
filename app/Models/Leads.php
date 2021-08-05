<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leads extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'leads';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'salutation',
        'first_name',
        'last_name',
        'owner',
        'lead_type',
        'industry',
        'phone',
        'business_phone',
        'email',
        'created_by'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function ownerLead(){
        return $this->belongsTo(Contacts::class, 'owner');
    }

    public function leadCreatedName() {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getUserNameAttribute(){
        return $this->name;
    }

    public function getFullNameAttribute(){
        $implode = [];

        if ($this->salutation) {
            $implode[] = ucwords($this->salutation);
        }
        if ($this->first_name) {
            $implode[] = $this->first_name;
        }

        if ($this->last_name) {
            $implode[] = $this->last_name;
        }
        return implode(' ', $implode);
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
