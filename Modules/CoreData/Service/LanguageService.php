<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\Language\Dashboard\LanguageResource;
use Modules\CoreData\Repositories\LanguageRepository;

class LanguageService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(LanguageRepository $repository)
    {
        $this->repo = $repository;
    }
    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$recursiveRel=[])
    {
        return $this->repo->findBy($request, pagination:$pagination,perPage: $perPage, get: $get,recursiveRel:$recursiveRel);
    }
    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        return $data;
    }

    public function list(Request $request,$pagination = false , $perPage = 10)
    {
        return LanguageResource::collection($this->repo->list($request,$pagination,$perPage));
    }

    public function delete($id)
    {
        $recursiveRel = [
        'translation'=> [
            'type' => 'WhereDoesntHave ',
        ],
        'users'=> [
            'type' => 'orWhereDoesntHave ',
        ],
    ];
        $data = $this->findBy(request:new Request(),get:'count',recursiveRel:$recursiveRel);
        if($data == 0){
            $this->repo->delete($id);
        return true;
        }else{
            return false;
        }
    }

}
