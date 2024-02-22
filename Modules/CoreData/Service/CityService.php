<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\City\Adviser\CityResource;
use Modules\CoreData\Repositories\CityRepository;

class CityService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(CityRepository $repository)
    {
        $this->repo = $repository;
    }

    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return CityResource::collection($this->repo->list($request,$pagination,$perPage));
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }
}
