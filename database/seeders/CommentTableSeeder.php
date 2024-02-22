<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Comment;

class CommentTableSeeder extends Seeder
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
                'name' => 'ليس فى مجالى',
                'type' => 'adviser',
            ], [
                'name' => 'لم يعجبنى الرد',
                'type' => 'client',
            ],
        ];
        foreach($status as $value)
        {
            $data = Comment::create(['status' => 1,'type'=>$value['type']]);
            foreach(language() as $lang)
            {
                $data->translation()->create(['key' => 'name', 'value' => $value['name'], 'language_id' => $lang->id]);
            }
        }
    }
}
