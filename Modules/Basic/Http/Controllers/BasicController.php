<?php

namespace Modules\Basic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Basic\Traits\ApiResponseTrait;

class BasicController extends Controller
{
    use ApiResponseTrait;

    public function destroy($id)
    {
        return $this->deleteResponse($this->service->delete($id));
    }

    public function perPage()
    {
        return !isset(Request()->perPage) ? 10 : Request()->perPage;
    }

    public function pagination()
    {
        return !isset(Request()->pagination) ? false : Request()->pagination;
    }

    public function changeStatus($id)
    {
        $data= $this->service->changeStatus($id, 'status');
        if($data)
        {
            return $this->apiResponse([], 'Done');
        }
        return $this->unKnowError();
    }
}
