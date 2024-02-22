<?php

namespace Modules\Basic\Service;

use Modules\Basic\Repositories\MediaRepository;

class MediaService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(MediaRepository $repository)
    {
        $this->repo = $repository;
    }

}
