<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\Role\Dashboard\RoleResource;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Basic\Service\BasicService;

class RoleService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(RoleRepository $repository)
    {
        $this->repo = $repository;
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }

    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return RoleResource::collection($this->repo->list($request,$pagination, $perPage));
    }
}
