<?php

namespace App\Repositories;

use App\Http\Resources\Options\OptionBackEndResource;
use App\Models\options;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class OptionRepository.
 */
class OptionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return options::class;
    }

    public function findParent($id)
    {
        $parent = $this->model->find($id);
        if($parent){
            return true;
        }
        return false;
    }
    public function getTypesByParentIDs($arr, $resource=true, $execpt = [])
    {
        $types = $this->model->whereIn('parent_id', $arr)->where('active', 1)->get();
        OptionBackEndResource::withoutWrapping();
        return OptionBackEndResource::collection($types);
    }
}
