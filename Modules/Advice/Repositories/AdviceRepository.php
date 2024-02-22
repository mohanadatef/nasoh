<?php

namespace Modules\Advice\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Advice\Entities\Advice;

class AdviceRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name', 'price', 'adviser_id', 'client_id', 'tax', 'tax_adviser', 'status_id', 'payment_id', 'rate_other',
        'rate_speed', 'rate_quality', 'rate_flexibility', 'rate_adviser', 'rate_app', 'label_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Advice::class;
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
        $moreConditionForFirstLevel = [], $recursiveRel = [])
    {
        return $this->all(search: $request->all(), pagination: $pagination, perPage: $perPage, get: $get,
            orderBy: $orderBy, moreConditionForFirstLevel: $moreConditionForFirstLevel, recursiveRel: $recursiveRel);
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
            }
            return $this->find($data->id);
        });
    }

    public function sumAdviceRate($id, $type)
    {
        return $this->model->where('status_id', 2)->where('adviser_id', $id)->sum($type);
    }
}
