<?php

namespace App\Models;

use App\Repositories\OptionRepository;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class Contacts extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'contacts';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $casts = [
        'identity_card_photos' => 'array'
    ];

    protected $fillable = [
        'ref_id',
        'ref_resource',
        'salesforce_id',
        'last_sync_modify',
        'account_id',
        'address_account',
        'user_id_fk',
        'is_vip',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_2',
        'phone_3',
        'phone_4',
        'street_no',
        'house_no',
        'address',
        'relationships',
        'working_field',
        'identity_card',
        'identity_card_photos',
        'profile',
        'salutation',
        'occupation',
        'date_of_birth',
        'owner',
        'assistan_name',
        'deprtement',
        'fax',
        'lead_source',
        'reports_to',
        'remark',
        'title',
        'description',
        'owner_account_id',
        'created_by',
        'updated_by'
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $fieldCode = '_code';

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
    protected $options;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function contactOwnerEntity()
    {
        return $this->belongsTo(Contacts::class, 'owner');
    }

    public function ContactsCreatedName() {
        return $this->belongsTo(Contacts::class,'created_by');
    }
    public function ContactsUpdatedName() {
        return $this->belongsTo(Contacts::class,'updated_by');
    }
    public function ContactOwner()
    {
        return $this->belongsTo(Contacts::class, 'owner_account_id');
    }
    
    // public function accountEntity()
    // {
    //     return $this->belongsTo(Account::class, 'account_id', 'id');
    // }
    public function accountNameEntity()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
    // public function reportToEntity()
    // {
    //     return $this->belongsTo(Account::class, 'reports_to', 'id');
    // }
    public function addressEntity()
    {
        return $this->belongsTo(Address::class, 'address', '_code');
    }
    // public function addressAccountEntity()
    // {
    //     return $this->belongsTo(\App\Models\Address::class, 'address_account', '_code');
    // }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeWhereColumnConcats($query, $value, $column = [], $operation = ' '){
        if(is_array($column) && count($column)){
            $likeString = env('DB_CONNECTION') === 'pgsql' ? 'ILIKE' : 'like';
            $concat = implode(", '".$operation."',", $column);
            return $query->where(DB::raw("CONCAT({$concat})"), $likeString, '%'.$value.'%');
        }
        return $query;
    }

    public function scopeSearchText($query, $value = false) // Search Fullname & Phone
    {
        $query->WhereColumnConcats($value, ['salutation','first_name','last_name','phone']);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getFullNameAttribute()
    {
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
    public function setIdentityCardPhotosAttribute($value)
    {
        $attribute_name = "identity_card_photos";
        $disk = 'contects';
        $destination_path = "contects/images";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }

    public function setProfileAttribute($value)
    {
        $attribute_name = "profile";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = "public/uploads";

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image')) {
            // 0. Make the image
            $image = Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value . time()) . '.jpg';

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it 
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path . '/' . $filename;
        }
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($obj) {
            if (count((array)$obj->photos)) {
                foreach ($obj->photos as $file_path) {
                    \Storage::disk('public_folder')->delete($file_path);
                }
            }
        });
    }
}
