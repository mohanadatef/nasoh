<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\Permission\Dashboard\PermissionResource;
use Modules\Acl\Repositories\PermissionRepository;
use Modules\Basic\Service\BasicService;

class PermissionService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(PermissionRepository $repository)
    {
        $this->repo = $repository;
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }
    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return PermissionResource::collection($this->repo->list($request,$pagination,$perPage));
    }
}
