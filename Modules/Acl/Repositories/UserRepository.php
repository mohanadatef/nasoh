<?php

namespace Modules\Acl\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Basic\Repositories\BasicRepository;

class UserRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',  'email',  'role_id', 'lang','is_notification','name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
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

    public function findBy(Request $request,$pagination = false , $perPage = 10,$orderBy = [],$get='')
    {
        return $this->all($request->all(), orderBy:$orderBy,pagination:$pagination,perPage:$perPage,get:$get);
    }

    public function list(Request $request,$pagination = false , $perPage = 10,$moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), pagination: $pagination,perPage: $perPage,moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function () use ($request, $id) {
            if (isset($request->password)) {
                $request->merge(['password' => Hash::make($request->password)]);
            }
            if ($id) {
                $data = $this->update($request->all(), $id);
            } else {
                $data = $this->create($request->all());
            }
            if (isset($request->logo) && !empty($request->logo)) {
                $this->checkMediaDelete($data, $request, mediaType()['lm']);
                $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'], mediaType()['lm']);
            }
            return isset($id) ? $this->findOne($id) : $data;
        });
    }

}
