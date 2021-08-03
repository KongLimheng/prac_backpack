<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Account extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'accounts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'parent_id',
        'account_number',
        'bank_branch',
        'billing_address',
        'address',
        'valid_until',
        'name',
        'email',
        'phone',
        'industry',
        'rating',
        'website',
        'description',
        'lft',
        'rgt',
        'depth',
        'annual_revenur',
        'number_of_employees',
        'fax',
        'ownership',
        'sic',
        'ticker_symbol',
        'type',
        'owner',
        'create_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'logo',
        'alias'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getLftName()
    {
        return 'lft';
    }
    
    public function getRgtName()
    {
        return 'rgt';
    }
    
    public function getParentIdName()
    {
        return 'parent_id';
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(self::class,'parent_id')->with('children');
    }
    public function createBy()
    {
        return $this->belongsTo(Contacts::class, 'create_by', 'id');
    }
    public function ownerAcc()
    {
        return $this->belongsTo(Contacts::class, 'owner', 'id');
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
    public function getIndustryFormatAttribute()
    {
        return $this->industry;
    }
    public function getRatingFormatAttribute()
    {
        return $this->rating;
    }
    public function getAddressFormatAttribute()
    {
        return $this->address;
    }
    public function getOwnershipFormatAttribute()
    {
        return $this->ownership;
    }
    public function getParentFormatAttribute()
    {
        return optional($this->parent)->name;
    }
    public function getOwnerFormatAttribute()
    {
        return optional($this->ownerAcc)->FullName;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    // public function setParentAttribute($value)
    // {
    //     $this->setParentIdAttribute($value);
    // }
    public function setLogoAttribute($value)
    {
        $attribute_name = "logo";
        // or use your own disk, defined in config/filesystems.php
        $disk = 'uploads'; 
        // destination path relative to the disk above
        $destination_path = "uploads/images"; 

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            \Storage::disk($disk)->delete($this->{$attribute_name});
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }else{
            $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    
        }
    }
}
