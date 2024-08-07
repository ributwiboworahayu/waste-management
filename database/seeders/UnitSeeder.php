<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // list satuan untuk limbah b3
        $data = [
            // Berat
            ['name' => 'Kilogram', 'symbol' => 'Kg', 'description' => 'Kilogram'],
            ['name' => 'Gram', 'symbol' => 'g', 'description' => 'Gram'],
            ['name' => 'Milligram', 'symbol' => 'mg', 'description' => 'Milligram'],
            ['name' => 'Ton', 'symbol' => 't', 'description' => 'Ton'],
            ['name' => 'Microgram', 'symbol' => 'µg', 'description' => 'Microgram'],
            ['name' => 'Picogram', 'symbol' => 'pg', 'description' => 'Picogram'],
            ['name' => 'Kiloton', 'symbol' => 'kt', 'description' => 'Kiloton'],

            // Volume
            ['name' => 'Liter', 'symbol' => 'L', 'description' => 'Liter'],
            ['name' => 'Milliliter', 'symbol' => 'mL', 'description' => 'Milliliter'],
            ['name' => 'Kubik Centimeter', 'symbol' => 'cm³', 'description' => 'Kubik Centimeter'],
            ['name' => 'Kubik Meter', 'symbol' => 'm³', 'description' => 'Kubik Meter'],
            ['name' => 'Kubik Millimeter', 'symbol' => 'mm³', 'description' => 'Kubik Millimeter'],
            ['name' => 'Nanoliter', 'symbol' => 'nL', 'description' => 'Nanoliter'],
            ['name' => 'Picoliter', 'symbol' => 'pL', 'description' => 'Picoliter'],
            ['name' => 'Microliter', 'symbol' => 'µL', 'description' => 'Microliter'],
            ['name' => 'Dekaliter', 'symbol' => 'daL', 'description' => 'Dekaliter'],
            ['name' => 'Hektoliter', 'symbol' => 'hL', 'description' => 'Hektoliter'],
            ['name' => 'Dekameter Kubik', 'symbol' => 'dam³', 'description' => 'Dekameter Kubik'],
            ['name' => 'Hektometer Kubik', 'symbol' => 'hm³', 'description' => 'Hektometer Kubik'],
            ['name' => 'Kilometer Kubik', 'symbol' => 'km³', 'description' => 'Kilometer Kubik'],

            // Panjang
            ['name' => 'Meter', 'symbol' => 'm', 'description' => 'Meter'],
            ['name' => 'Centimeter', 'symbol' => 'cm', 'description' => 'Centimeter'],
            ['name' => 'Millimeter', 'symbol' => 'mm', 'description' => 'Millimeter'],
            ['name' => 'Kilometer', 'symbol' => 'km', 'description' => 'Kilometer'],
            ['name' => 'Nanometer', 'symbol' => 'nm', 'description' => 'Nanometer'],
            ['name' => 'Dekameter', 'symbol' => 'dam', 'description' => 'Dekameter'],
            ['name' => 'Hektometer', 'symbol' => 'hm', 'description' => 'Hektometer']
        ];


        collect($data)->each(function ($unit) {
            Unit::create($unit);
        });
    }
}
