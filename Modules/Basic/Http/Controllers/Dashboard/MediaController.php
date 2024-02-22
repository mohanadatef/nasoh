<?php

namespace Modules\Basic\Http\Controllers\Dashboard;

use Modules\Basic\Http\Controllers\BasicController;
use Modules\Basic\Service\MediaService;

class MediaController extends BasicController
{
    public $service;

    public function __construct(MediaService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->service = $Service;
    }

}
