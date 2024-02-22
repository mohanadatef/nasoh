<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\CoreData\Entities\City;
use Modules\CoreData\Entities\Country;
use Modules\CoreData\Service\CityService;
use Modules\CoreData\Service\CountryService;

class CsvFileSeeder extends Seeder
{
    public function __construct(CountryService $countryService,CityService $cityService)
    {
        $this->countryService = $countryService;
        $this->cityService = $cityService;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        executionTime();
        $csvFile = fopen(base_path("database/seeders/country.csv"), "r");

        $counter = 0;

        $this->command->getOutput()->progressStart(5000);

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            executionTime();
            $this->command->getOutput()->writeln("start " . $counter);
           $country= $this->countryService->findBy(new Request(['name'=>$data[0]]))->first();
           if(empty($country))
           {
               $country = Country::create(['status'=>1]);
               foreach (language() as $lang) {
                   $country->translation()->create(['key' => 'name', 'value' => $data[0], 'language_id' => $lang->id]);
               }
           }
            $city= $this->cityService->findBy(new Request(['name'=>$data[1]]))->first();
            if(empty($city))
            {
                $city = City::create(['status'=>1,'country_id'=>$country->id]);
                foreach (language() as $lang) {
                    $city->translation()->create(['key' => 'name', 'value' => $data[1], 'language_id' => $lang->id]);
                }
            }
            $this->command->getOutput()->progressAdvance();
            $this->command->getOutput()->writeln("end " . $counter);
            $counter++;

        }

        fclose($csvFile);
    }

}
