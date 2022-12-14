<?php

namespace Database\Seeders;

use App\Models\{Country, State, City};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountryStateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countryJson = File::get("database/data/countries.json");
        $countryData = json_decode($countryJson, true);

        $countryDataArray = [];
        foreach ($countryData as $obj) {
            $countryDataArray[] = [
                'sortname' => $obj['iso2'],
                'name' => $obj['name'],
                'phonecode' => $obj['phone_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Country::insert($countryDataArray);

        $stateJson = File::get("database/data/states.json");
        $stateData = json_decode($stateJson, true);

        $stateDataArray = [];
        foreach ($stateData as $obj) {
            $stateDataArray[] = [
                'name' => $obj['name'],
                'country_id' => $obj['country_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $stateDataArray = collect($stateDataArray);
        $chunksStateDataArray = $stateDataArray->chunk(1000);

        foreach ($chunksStateDataArray as $chunk) {
            State::insert($chunk->toArray());
        }

        $cityJson = File::get("database/data/cities.json");
        $cityData = json_decode($cityJson, true);

        $cityDataArray = [];
        foreach ($cityData as $obj) {
            $cityDataArray[] = [
                'name' => $obj['name'],
                'state_id' => $obj['state_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $cityDataArray = collect($cityDataArray);
        $chunksCityDataArray = $cityDataArray->chunk(1000);

        foreach ($chunksCityDataArray as $chunk) {
            City::insert($chunk->toArray());
        }
    }
}
