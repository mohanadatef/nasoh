<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\Nationality\Dashboard\NationalityResource;
use Modules\CoreData\Repositories\NationalityRepository;

class NationalityService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(NationalityRepository $repository)
    {
        $this->repo = $repository;
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }
    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return NationalityResource::collection($this->repo->list($request,$pagination,$perPage));
    }

}
