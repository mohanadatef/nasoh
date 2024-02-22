<?php


namespace Modules\Basic\Repositories;

use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Traits\ChangeTrait;
use Modules\Basic\Traits\LanguageTrait;
use Modules\Basic\Traits\MediaTrait;

abstract class BasicRepository
{
    use ChangeTrait, LanguageTrait, MediaTrait;

    /**
     * @var Model
     */
    protected $model;

    /**
     * Configure the Model
     *
     * @return string
     */

    abstract public function model();

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Make Model instance
     *
     * @return Model
     * @throws \Exception
     *
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    abstract public function getFieldsRelationShipSearchable();

    abstract public function translationKey();

    /**
     * Display a listing of the resource.
     * column is array with we select it from table
     */
    public function all($search = [], $column = ['*'], $withRelations = [], $recursiveRel = [], $moreConditionForFirstLevel = [], $pluck = [],
                        $orderBy = [], $get = '', $skip = null, $limit = null, $pagination = false, $perPage = 0, $latest = '', $distinct = null, $groupBy = null)
    {
        $query = $this->allQuery($search, $skip, $limit, $latest, $distinct, $groupBy);
        if ($recursiveRel != []) {
            $query = $this->addRecursiveRelationsToQuery($query, $recursiveRel);
        }
        if ($moreConditionForFirstLevel) {
            if (count($moreConditionForFirstLevel) == 1) {
                $query = self::proccessQuery($query, $moreConditionForFirstLevel);
            } else {
                foreach ($moreConditionForFirstLevel as $key => $value) {
                    $query = self::proccessQuery($query, [$key => $value]);
                }
            }
        }
        if (!empty($orderBy)) {
            $query = $query->orderBy($orderBy['column'], $orderBy['order']);
        }
        if (!empty($withRelations)) {
            $query = $this->with($query, $withRelations);
        }
        if (!empty($column) && $column != ['*']) {
            $query = $query->select($column);
        }

        if (!empty($pluck)) {
            return $query->pluck($pluck[0], $pluck[1]);
        } elseif ($get == 'toArray') {
            return $query->toArray();
        } elseif ($get == 'count') {
            return $query->count();
        } elseif ($get == 'first') {
            return $query->first();
        } elseif ($pagination == true && $perPage != 0) {
            return $query->paginate($perPage);
        } else {
            return $query->get();
        }
    }

    public function find($id, $column = ['*'], $withRelations = [])
    {
        $query = $this->model->newQuery();
        if (!empty($withRelations)) {
            $query = $this->with($query, $withRelations);
        }
        return $query->find($id, $column);
    }

    public function with($query, $withRelations)
    {
        return $query->with($withRelations);
    }

    public function create($request)
    {
        return $this->model->create($request);
    }

    public function update($request, $id = null)
    {
        $data = $this->find($id);
        $data->update($request);
        return $this->find($id);
    }

    public function allQuery($search = [], $skip = null, $limit = null, $latest = '', $distinct = null, $groupBy = null)
    {
        $query = $this->model->newQuery();
        if (count($search) > 0) {
            foreach ($search as $key => $value) {
                if ((!empty($value) && $value != null && $value != "null") || $value === 0 || $value === "0") {
                    if (in_array($key, $this->getFieldsSearchable())) {
                        if (isset($this->model->searchConfig) && !is_array($value) && array_key_exists($key, $this->model->searchConfig) && !empty
                            ($this->model->searchConfig[$key])) {
                            if ($this->model->searchConfig[$key] == 'like' || $this->model->searchConfig[$key] == 'LIKE') {
                                $condition = $this->model->searchConfig[$key] == 'like' || $this->model->searchConfig[$key] == 'LIKE';
                                $query->where($key, $this->model->searchConfig[$key], $condition ? '%' . $value . '%' : $value);
                            }
                        } else {
                            if (is_array($value)) {
                                $query->whereIn($key, $value);
                            } elseif (strpos($value, ',') !== false) {
                                $query->whereIn($key, explode(',', $value));
                            } else {
                                $query->where($key, $value);
                            }
                        }
                    }
                    if (!empty($this->translationKey()) && in_array($key, $this->translationKey())) {
                        $query->whereHas('translation', function ($query) use ($key, $value) {
                            if (is_array($value)) {
                                $query->where('key', $key)->whereIn('value', $value);
                            } elseif (strpos($value, ',') !== false) {
                                $query->whereIn($key, explode(',', $value));
                            } elseif (isset($this->model->searchConfig) && !is_array($value) && array_key_exists($key, $this->model->searchConfig) && !empty
                                ($this->model->searchConfig[$key])) {
                                $condition = $this->model->searchConfig[$key] == 'like' || $this->model->searchConfig[$key] == 'LIKE';
                                $query->where('key', $key)->where('value', $this->model->searchConfig[$key], $condition ? '%' . $value . '%' : $value);
                            } else {
                                $query->where('key', $key)->where('value', $value);
                            }
                        });
                    }
                    if (!empty($this->getFieldsRelationShipSearchable()) && array_key_exists($key, $this->getFieldsRelationShipSearchable())) {
                        $relation = explode("->", $this->model->searchRelationShip[$key]);
                        $condition = isset($relation[2]) ? $relation[2] : null;
                        if((!empty($value) && $value != null && $value != "null") || $value === 0 || $value === "0")
                        {
                        $query->whereHas($relation[0], function ($query) use ($value, $relation, $condition) {
                            if (is_array($value)) {
                                $query->whereIn($relation[1], $value);
                            } elseif (strpos($value, ',') !== false) {
                                $query->whereIn($relation[1], explode(',', $value));
                            }  elseif (!isset($relation[2])) {
                                $query->where($relation[1], $value);
                            }else {
                                $query->where($relation[1], $condition, '%' . $value . '%');
                            }
                        });
                        }
                    }
                }
            }
        }
        if (!is_null($skip)) {
            $query->skip($skip);
        }
        if (!is_null($limit)) {
            $query->limit($limit);
        }
        if ($latest == 'latest') {
            $query->latest();
        }
        if (!is_null($distinct)) {
            $query->distinct($distinct);
        }
        if (!is_null($groupBy)) {
            $query->groupBy($groupBy);
        }
        return $query;
    }

    public function addRecursiveRelationsToQuery($query, $withRecursive)
    {
        foreach ($withRecursive as $key => $value) {
            if (!isset($value['type']) || $value['type'] == 'normal') {
                $query = $query->with([$key => function ($q) use ($key, $value) {
                    $q = self::proccessQuery($q, $value);
                    if (isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                }]);
            } elseif ($value['type'] == 'whereHas') {// use relation whereHas
                $query = $query->whereHas($key, function ($q) use ($key, $value) {
                    $q = self::proccessQuery($q, $value);
                    if (isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            } elseif (in_array($value['type'], ['whereDoesntHave', 'orWhereDoesntHave'])) {// use relation doesntHave
                $query = $query->{$value['type']}($key, function ($q) use ($key, $value) {
                    $q = self::proccessQuery($q, $value);
                    if (isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            } elseif ($value['type'] == 'orWhereHas') {// use relation whereHas
                $query = $query->orWhereHas($key, function ($q) use ($key, $value) {
                    $q = self::proccessQuery($q, $value);
                    if (isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            } elseif (in_array($value['type'], ['whereHasMorph', 'orWhereHasMorph'])) {
                $query = $query->{$value['type']}($key, '*', function ($q, $type) use ($key, $value) {
                    $q = self::proccessQuery($q, $value);
                    if (isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            } elseif ($value['type'] == 'orWhereHas') {// use relation whereHas
                $query = $query->orWhereHas($key, function ($q) use ($key, $value) {
                    $q = self::proccessQuery($q, $value);
                    if (isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            }
        }
        return $query;
    }

    public function proccessQuery($q, $values)
    {
        if (isset($values['where']) && count($values['where']) > 0) {
            foreach ($values['where'] as $key => $value) {
                if (isset($this->model->searchConfig) && array_key_exists($key, $this->model->searchConfig) && !empty($this->model->searchConfig[$key])) {
                    $q->where($key, $this->model->searchConfig[$key], '%' . $value . '%');
                } else {
                    $q = $this->proccessWhere($q, $key, $value);
                }
            }
        }
        if (isset($values['whereBetween']) && count($values['whereBetween']) > 0) {
            foreach ($values['whereBetween'] as $key => $value) {
                $q->whereBetween($key, [$value[0], $value[1]]);
            }
        }
        if (isset($values['orWhereBetween']) && count($values['orWhereBetween']) > 0) {
            foreach ($values['orWhereBetween'] as $key => $value) {
                $q->orwhereBetween($key, [$value[0], $value[1]]);
            }
        }
        if (isset($values['whereQuery']) && count($values['whereQuery']) > 0) {
            foreach ($values['whereQuery'] as $value) {
                $num = 0;
                $q->where(function ($query) use ($num, $value) {
                    foreach ($value as $k => $val) {
                        if ($num == 0) {
                            $query = $this->proccessWhere($query, $k, $val);
                        } else {
                            $query = $this->proccessOrWhere($query, $k, $val);
                        }
                        $num++;
                    }
                });
            }
        }
        if (isset($values['whereCustom']) && count($values['whereCustom']) > 0) {
            $num = 0;
            $q->where(function ($query) use ($num, $values) {
                foreach ($values['whereCustom'] as $ke => $value) {
                    foreach ($value as $valC) {
                        if (in_array($ke, ['whereDoesntHave', 'whereHasMorph', 'orWhereHasMorph', 'whereHas'])) {
                            $query = self::addRecursiveRelationsToQuery($query, $valC);
                        } else
                            foreach ($valC as $k => $val) {
                                if ($ke == 'where') {
                                    if ($num == 0)
                                        $query = $this->proccessWhere($query, $k, $val);
                                    else
                                        $query = $this->proccessOrWhere($query, $k, $val);
                                } elseif ($ke == 'orWhereNull') {
                                    $query = $this->proccessOrWhereNull($query, $val);
                                }
                                $num++;
                            }
                    }
                }
            });
        }
        if (isset($values['orWhereNotNull']) && count($values['orWhereNotNull']) > 0) {
            $q = $this->whereNotNull($q, $values['orWhereNotNull']);
        }
        if (isset($values['whereNotNull']) && count($values['whereNotNull']) > 0) {
            $q = $this->whereNotNull($q, $values['whereNotNull']);
        }
        if (isset($values['whereNull']) && count($values['whereNull']) > 0) {
            $q = $this->whereNull($q, $values['whereNull']);
        }
        if (isset($values['orWhereNull']) && count($values['orWhereNull']) > 0) {
            $num = 0;
            foreach ($values['orWhereNull'] as $column) {
                if ($num == 0)
                    $q->whereNull($column);
                else
                    $q->orWhereNull($column);
                $num++;
            }
        }
        if (isset($values['orWherePivot']) && count($values['orWherePivot']) > 0) {
            foreach ($values['orWherePivot'] as $where => $value) {
                $q->orWhere($where, $value);
            }
        }
        if (isset($values['whereIn']) && count($values['whereIn']) > 0) {
            foreach ($values['whereIn'] as $where => $value) {
                $q->whereIn($where, $value);
            }
        }
        if (isset($values['whereNotIn']) && count($values['whereNotIn']) > 0) {
            foreach ($values['whereNotIn'] as $where => $value) {
                $q->whereNotIn($where, $value);
            }
        }
        if (isset($values['orWhere']) && count($values['orWhere']) > 0) {
            $num = 0;
            foreach ($values['orWhere'] as $where => $value) {
                $q = $this->proccessOrWhere($q, $where, $value);
            }
        }
        if (isset($values['doesntHave']) && count($values['doesntHave']) > 0) {
            foreach ($values['doesntHave'] as $val) {
                $q->doesntHave($val);
            }
        }
        return $q;
    }

    public function proccessOrWhereNull($query, $val)
    {
        return $query->orWhereNull($val);
    }

    public function proccessOrWhere($q, $key, $value)
    {
        if (is_array($value) && count($value) == 2)
            $q->orWhere($key, $value[0], $value[1]);
        else
            $q->orWhere($key, $value);
        return $q;
    }

    public function whereNotNull($q, $values)
    {
        $num = 0;
        foreach ($values as $column) {
            if ($num == 0)
                $q->whereNotNull($column);
            else
                $q->orWhereNotNull($column);
            $num++;
        }
        return $q;
    }

    public function whereNull($q, $values)
    {
        $num = 0;
        foreach ($values as $column) {
            if ($num == 0)
                $q->whereNull($column);
            else
                $q->orWhereNull($column);
            $num++;
        }
        return $q;
    }

    public function proccessWhere($q, $key, $value)
    {
        if (is_array($value) && count($value) == 2)
            $q->where($key, $value[0], $value[1]);
        else
            $q->where($key, $value);
        return $q;
    }

    public function updateValue($id, $key)
    {
        return $this->change($this->find($id), $key);
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
            return $data;
        });
    }

    public function delete($id)
    {
        $data = $this->find($id, ['*'], [], true);
        return $data ? $data->delete() : false;
    }

}
