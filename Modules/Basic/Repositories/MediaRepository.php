<?php

namespace Modules\Basic\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Entities\Media;

class MediaRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'
    ];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Media::class;
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
    public function translationKey()
    {
        return $this->model->translationKey();
    }
    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }
}
