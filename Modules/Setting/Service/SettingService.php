<?php

namespace Modules\Setting\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Setting\Repositories\SettingRepository;

class SettingService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(SettingRepository $repository)
    {
        $this->repo = $repository;
    }

    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return $this->repo->list($request,$pagination,$perPage);
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }
}
