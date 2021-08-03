<?php

namespace App\Http\Resources\Options;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionBackEndResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'value' => $this->code,
            'text' => $this->DynamicName,
            'parent_id' => $this->parent_id,
            'active' => $this->active = 0 ? false : true,
            'name_khm' => $this->name_khm
        ];
    }
}
