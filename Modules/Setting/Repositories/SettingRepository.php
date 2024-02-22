<?php

namespace Modules\Setting\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Setting\Entities\Setting;

class SettingRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'value', 'key'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
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
            foreach($request->value as $key => $value)
            {
                $data = $this->findBy(new Request(['key' => $key]), get:'first');
                if($data)
                {
                    $data->update(['value' => $value]);
                }
            }
            return true;
        });
    }
}
