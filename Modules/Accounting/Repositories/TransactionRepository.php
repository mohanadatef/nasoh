<?php

namespace Modules\Accounting\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Transaction;
use Modules\Basic\Repositories\BasicRepository;

class TransactionRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'key'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Transaction::class;
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
        $recursiveRel = [])
    {
        return $this->all($request->all(), orderBy: $orderBy, pagination: $pagination, perPage: $perPage, get: $get);
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
}
