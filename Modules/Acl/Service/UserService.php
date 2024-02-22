<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\User\Dashboard\UserResource;
use Modules\Acl\Repositories\UserRepository;
use Modules\Basic\Service\BasicService;

class UserService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }
    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return UserResource::collection($this->repo->findBy($request, pagination:  $pagination, perPage: $perPage,orderBy:['column'=>'id','order'=>'desc']));
    }
}
