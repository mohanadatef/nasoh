<?php

namespace Modules\Basic\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ChangeTrait
{
    public function change($datas,$key = 'status')
    {
        if ($datas instanceof Collection) {
            foreach ($datas as $data) {
                $data[$key] = ($data[$key] == 1 ? 0 : 1);
                $data->update();
            }
        } else {
            $datas[$key] = ($datas[$key] == 1 ? 0 : 1);
            $datas->update();
        }
        return $datas;
    }
}
