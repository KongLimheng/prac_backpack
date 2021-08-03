<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class options extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $table = 'options';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'code',
        'active',
        'type',
        'parent_id',
        'lft',
        'rgt',
        'depth',
        'created_by',
        'update_by',
        'name_khm',
    ];

    
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

    public function scopeParentNotNull($qury, $id)
    {
        return $qury->where('parent_id', $id);
    }

    public function scopeParentNull($qury)
    {
        return $qury->whereNull('parent_id');
    }
}
