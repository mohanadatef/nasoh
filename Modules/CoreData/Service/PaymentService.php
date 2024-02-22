<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Repositories\PaymentRepository;

class PaymentService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(PaymentRepository $repository)
    {
        $this->repo = $repository;
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy);
    }
    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return $this->repo->list($request,$pagination,$perPage);
    }

}
