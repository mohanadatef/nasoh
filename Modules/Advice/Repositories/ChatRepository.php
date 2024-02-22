<?php

namespace Modules\Advice\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Advice\Entities\Chat;

class ChatRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'message', 'advice_id', 'adviser_id', 'client_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Chat::class;
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

    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '', $orderBy = [],
        $moreConditionForFirstLevel = [])
    {
        return $this->all(search: $request->all(), pagination: $pagination, perPage: $perPage, get: $get,
            orderBy: $orderBy, moreConditionForFirstLevel: $moreConditionForFirstLevel);
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
            if(isset($request->document[0]['file']) && isset($request->document[0]['type']) && !empty($request->document[0]['file']) && !empty($request->document[0]['type']))
            {
                $request->merge(['media_type' => 1]);
            }
            $data = $this->create($request->all());
            if(isset($request->document[0]['file']) && isset($request->document[0]['type']) && !empty($request->document[0]['file']) && !empty($request->document[0]['type']))
            {
                $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'], mediaType()['dm']);
            }
            return $this->find($data->id);
        });
    }
}
