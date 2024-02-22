<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\Nationality;

class NationalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nationality = [
            [
                'order' => 0,
                'name' => 'المملكة العربية السعودية',
                'file' => 'سعودي.png',
                'code'=>'966'
            ],
            [
                'order' => 1,
                'name' => 'الامارات العربية المتحدة',
                'file' => 'اماراتي.png',
                'code'=>'971'
            ],
            [
                'order' => 2,
                'name' => 'الكويت',
                'file' => 'كويتي.png',
                'code'=>'965'
            ],
            [
                'order' => 3,
                'name' => 'عمان',
                'file' => 'عوماني.png',
                'code'=>'968'
            ],
            [
                'order' => 4,
                'name' => 'قطر',
                'file' => 'قطري.png',
                'code'=>'974'
            ],
            [
                'order' => 5,
                'name' => 'البحرين',
                'file' => 'بحريني.png',
                'code'=>'973'
            ],
            [
                'order' => 6,
                'name' => 'مصر',
                'file' => 'مصري.png',
                'code'=>'20'
            ],
            [
                'order' => 7,
                'name' => 'السودان',
                'file' => 'سوداني.png',
                'code'=>'249'
            ],
            [
                'order' => 8,
                'name' => 'العراق',
                'file' => 'عراقي.png',
                'code'=>'964'
            ],
            [
                'order' => 9,
                'name' => 'المغرب',
                'file' => 'مغربي.png',
                'code'=>'212'
            ],
            [
                'order' => 10,
                'name' => 'الأردن',
                'file' => 'اردني.png',
                'code'=>'962'
            ],
            [
                'order' => 11,
                'name' => 'اليمن',
                'file' => 'يمني.png',
                'code'=>'967'
                ],
            [
                'order' => 12,
                'name' => 'تونس',
                'file' => 'تونسي.png',
                'code'=>'216'
                ],
            [
                'order' => 13,
                'name' => 'جيبوتي',
                'file' => 'جيبوتي.png',
                'code'=>'253'
                ],
            [
                'order' => 14,
                'name' => 'سوريا',
                'file' => 'سوري.png',
                'code'=>'963'
                ],
            [
                'order' => 15,
                'name' => 'فلسطين',
                'file' => 'فلسطيني.png',
                'code'=>'970'
                ],
            [
                'order' => 16,
                'name' => 'لبنان',
                'file' => 'لبناني.png',
                'code'=>'961'
                ],
            [
                'order' => 17,
                'name' => 'الجزائر',
                'file' => 'جزائري.png',
                'code'=>'213'
                ],
            [
                'order' => 18,
                'name' => 'ليبيا',
                'file' => 'ليبي.png',
                'code'=>'218'
                ],
            [
                'order' => 19,
                'name' => 'موريتانيا',
                'file' => 'موريتاني.png',
                'code'=>'222'
            ],
        ];
        foreach ($nationality as $value) {
            $data = Nationality::create(['code'=>$value['code']]);
            foreach (language() as $lang) {
                $data->translation()->create(['key' => 'name', 'value' => $value['name'], 'language_id' => $lang->id]);
            }
            Media::create(['category_type'=>'Modules\CoreData\Entities\Nationality','category_id'=>$data->id,'file'=>$value['file'],'type'=>mediaType()['lm']]);
        }
    }
}
