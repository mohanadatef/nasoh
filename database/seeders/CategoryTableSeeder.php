<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Service\CategoryService;

class CategoryTableSeeder extends Seeder
{
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cc = Category::all();
        foreach($cc as $c)
        {
            $c->delete();
        }
        executionTime();
        $csvFile = fopen(base_path("database/seeders/category.csv"), "r");
        $counter = 0;
        $this->command->getOutput()->progressStart(5000);
        while(($data = fgetcsv($csvFile, 2000, ",")) !== false)
        {
            executionTime();
            $this->command->getOutput()->writeln("start " . $counter);
            $category = $this->categoryService->findBy(new Request(['name' => $data[0]]))->first();
            if(empty($category))
            {
                $category = Category::create(['status' => 1]);
                foreach(language() as $lang)
                {
                    $category->translation()
                        ->create(['key' => 'name', 'value' => $data[0], 'language_id' => $lang->id]);
                }
            }
            $children = $this->categoryService->findBy(new Request(['name' => $data[1]]))->first();
            if(empty($children))
            {
                $children = Category::create(['status' => 1, 'parent_id' => $category->id]);
                foreach(language() as $lang)
                {
                    $children->translation()
                        ->create(['key' => 'name', 'value' => $data[1], 'language_id' => $lang->id]);
                }
            }
            $this->command->getOutput()->progressAdvance();
            $this->command->getOutput()->writeln("end " . $counter);
            $counter++;
        }
        fclose($csvFile);
    }
}
