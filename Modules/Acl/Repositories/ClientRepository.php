<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Acl\Entities\Client;
use Modules\Basic\Repositories\BasicRepository;

class ClientRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'full_name', 'email', 'mobile', 'lang', 'gender', 'country_id', 'city_id', 'nationality_id', 'status', 'token',
        'is_notification', 'wallet'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Client::class;
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

    public function findBy(Request $request, $pagination = false, $perPage = 10, $orderBy = [], $get = '',
        $recursiveRel = [], $moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), orderBy: $orderBy, pagination: $pagination, perPage: $perPage, get: $get,
            recursiveRel: $recursiveRel, moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $moreConditionForFirstLevel = [])
    {
        return $this->all($request->all(), pagination: $pagination, perPage: $perPage,
            moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $data = $this->update($request->all(), $id);
            }else
            {
                $data = $this->create($request->all());
                $token = $data->createToken('nasooh client')->accessToken;
                $data->update(['token' => $token]);
                if($request->device)
                {
                    $data->device()->firstOrCreate(['device' => $request->device]);
                }
            }
            if(isset($request->avatar[0]['file'], $request->avatar[0]['type']) && !empty($request->avatar[0]['file']) && !empty($request->avatar[0]['type']))
            {
                $this->checkMediaDelete($data, $request, mediaType()['am']);
                $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                    mediaType()['am']);
            }
            return $this->find($data->id);
        });
    }
}
