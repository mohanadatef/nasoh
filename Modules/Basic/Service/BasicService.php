<?php

namespace Modules\Basic\Service;

use Illuminate\Http\Request;
use Modules\Acl\Traits\messageEmailTrait;
use Modules\Acl\Traits\otpTrait;
use Modules\Basic\Traits\validationRulesTrait;

class BasicService
{
    use messageEmailTrait, otpTrait,validationRulesTrait;


    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function show($id)
    {
        return $this->repo->find($id);
    }

    public function update(Request $request, $id)
    {
        return $this->repo->save($request, $id);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function changeStatus($id, $key)
    {
        $data = $this->repo->updateValue($id, $key);
        return $data;
    }
}
