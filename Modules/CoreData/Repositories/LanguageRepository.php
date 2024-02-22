<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Http\Request;
use Modules\Basic\Repositories\BasicRepository;
use Modules\CoreData\Entities\Language;

class LanguageRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code','id'
    ];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Language::class;
    }
    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }
    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }

    public function translationKey()
    {
        return $this->model->translationKey();
    }

    public function findBy(Request $request, $pagination = false , $perPage = 10,$get = '',$recursiveRel=[])
    {
        return $this->all(search:$request->all(),pagination:$pagination,perPage:$perPage,get:$get,recursiveRel:$recursiveRel);
    }
    public function list(Request $request,$pagination = false , $perPage = 10,$moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), pagination: $pagination,perPage: $perPage,moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }
}
