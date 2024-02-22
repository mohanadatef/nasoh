<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\Role;
use Modules\Basic\Repositories\BasicRepository;

class RoleRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id','name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
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
    public function findBy(Request $request, $pagination = false , $perPage = 10,$get = '',$orderBy=[],$moreConditionForFirstLevel=[])
    {
        return $this->all(search:$request->all(),pagination:$pagination,perPage:$perPage,get:$get,orderBy: $orderBy,moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }

    public function list(Request $request,$pagination = false , $perPage = 10,$moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), pagination: $pagination,perPage: $perPage,moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }
    public function save(Request $request,$id=null)
    {
        return DB::transaction(function () use ($request,$id) {
            if($id)
            {
                $data=$this->update($request->all(),$id);
            }else{
                $data = $this->create($request->all());
            }
            $data->permission()->sync((array)$request->permission);
            return $data;
        });
    }

}
