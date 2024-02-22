<?php

namespace Modules\Accounting\Service;

use Illuminate\Http\Request;
use Modules\Accounting\Repositories\TransactionRepository;
use Modules\Basic\Service\BasicService;


class TransactionService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(TransactionRepository $repository)
    {
        $this->repo = $repository;
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }
}
