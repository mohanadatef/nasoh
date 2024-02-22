<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'name' => 'الحالية',
            ],
            [
                'name' => 'مكتمله',
            ],
            [
                'name' => 'مرفوضه',
            ],
            [
                'name' => 'المعترضه',
            ],
            [
                'name' => 'متنهيه',
            ],
        ];
        foreach($status as $value)
        {
            $data = Status::create(['status' => 1]);
            foreach(language() as $lang)
            {
                $data->translation()->create(['key' => 'name', 'value' => $value['name'], 'language_id' => $lang->id]);
            }
        }
    }
}
