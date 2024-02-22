<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Label;

class LabelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $label = [
            [
                'name' => 'جديد',
            ],
            [
                'name' => 'قيد التنفيذ',
            ],
            [
                'name' => 'انتظار الاستلام',
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
        foreach($label as $value)
        {
            $data = Label::create(['status' => 1]);
            foreach(language() as $lang)
            {
                $data->translation()->create(['key' => 'name', 'value' => $value['name'], 'language_id' => $lang->id]);
            }
        }
    }
}
