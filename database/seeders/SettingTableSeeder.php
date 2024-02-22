<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Entities\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [[
            'key' => 'tax_client',
            'value' => 1,
        ],
            [
                'key' => 'support_client',
                'value' => 1,
            ],
            [
                'key' => 'support_adviser',
                'value' => 1,
            ], [
                'key' => 'fcm_secret_key',
                'value' => 'AAAAEAOU5dc:APA91bHSfIf37f-uT8XQGLkVO94U7tmdwpt6ETTiN9r3iB1Gmk2frOVjGv3Mli04MkpDqpEd1i42w1qT_mUF60C5q_IFqCY2ftgMsrSHu38Xx9euAPrn_DJqmt_M_cq_MnDYLhPB7Xf2',
            ], [
                'key' => 'app_adviser',
                'value' => "test",
            ], [
                'key' => 'ios_adviser',
                'value' => "test",
            ],
            ['key' => 'otp_authorization','value'=>"eyJhbGciOiJIUzI1NiJ9.eyJzZXJ2aWNlX2lkIjoiQVBlZTk2ZjUyNGYzMjc0MjI3OWRiMTRlMjQxMTExOWE3MCJ9.yBoy3EC-Y3eB9blWDFq-Q6rm01Y4Fus7eV1oxxsTq1s"],
            ['key' => 'otp_app_id','value'=>"APee96f524f32742279db14e2411119a70"],
        ];
        foreach($setting as $s)
        {
            $set = Setting::where('key', $s['key'])->first();
            if(!$set)
            {
                Setting::create($s);
            }
        }
    }
}
