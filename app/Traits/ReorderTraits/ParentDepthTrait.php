<?php

namespace App\Traits\ReorderTraits;

trait ParentDepthTrait
{
    use ReorderDepthTrait;

    public static function BootParentDepthTrait(){
        static::creating(function($obj){
            $obj = $obj->reorderDepth($obj, 'creating');
        });

        static::updating(function ($obj) {
            $obj = $obj->reorderDepth($obj, 'updating');
        });
    }
    
}
