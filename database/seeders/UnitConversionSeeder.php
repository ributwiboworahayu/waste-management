<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitConversion;
use Illuminate\Database\Seeder;

class UnitConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conversionRates = [
            // Berat
            'Kg' => [
                'g' => ['rate' => 1000, 'operator' => '*'],
                'mg' => ['rate' => 1_000_000, 'operator' => '*'],
                't' => ['rate' => 0.001, 'operator' => '*'],
                'µg' => ['rate' => 1_000_000_000, 'operator' => '*'],
                'pg' => ['rate' => 1_000_000_000_000, 'operator' => '*'],
                'kt' => ['rate' => 1e-6, 'operator' => '*']
            ],
            'g' => [
                'Kg' => ['rate' => 0.001, 'operator' => '/'],
                'mg' => ['rate' => 1000, 'operator' => '*'],
                't' => ['rate' => 1e-6, 'operator' => '*'],
                'µg' => ['rate' => 1_000_000, 'operator' => '*'],
                'pg' => ['rate' => 1_000_000_000_000, 'operator' => '*'],
                'kt' => ['rate' => 1e-9, 'operator' => '*']
            ],
            'mg' => [
                'Kg' => ['rate' => 1e-6, 'operator' => '/'],
                'g' => ['rate' => 0.001, 'operator' => '/'],
                't' => ['rate' => 1e-9, 'operator' => '*'],
                'µg' => ['rate' => 1000, 'operator' => '*'],
                'pg' => ['rate' => 1_000_000, 'operator' => '*'],
                'kt' => ['rate' => 1e-12, 'operator' => '*']
            ],
            't' => [
                'Kg' => ['rate' => 1000, 'operator' => '*'],
                'g' => ['rate' => 1_000_000, 'operator' => '*'],
                'mg' => ['rate' => 1_000_000_000, 'operator' => '*'],
                'µg' => ['rate' => 1_000_000_000_000, 'operator' => '*'],
                'pg' => ['rate' => 1_000_000_000_000_000, 'operator' => '*'],
                'kt' => ['rate' => 0.001, 'operator' => '*']
            ],
            'kt' => [
                'Kg' => ['rate' => 1_000_000, 'operator' => '*'],
                'g' => ['rate' => 1_000_000_000, 'operator' => '*'],
                'mg' => ['rate' => 1_000_000_000_000, 'operator' => '*'],
                'µg' => ['rate' => 1_000_000_000_000_000, 'operator' => '*'],
                'pg' => ['rate' => 1_000_000_000_000_000_000, 'operator' => '*']
            ],
            'µg' => [
                'Kg' => ['rate' => 1e-9, 'operator' => '/'],
                'g' => ['rate' => 1e-6, 'operator' => '/'],
                'mg' => ['rate' => 0.001, 'operator' => '/'],
                't' => ['rate' => 1e-12, 'operator' => '*'],
                'pg' => ['rate' => 1000, 'operator' => '*'],
                'kt' => ['rate' => 1e-15, 'operator' => '*']
            ],
            'pg' => [
                'Kg' => ['rate' => 1e-12, 'operator' => '/'],
                'g' => ['rate' => 1e-9, 'operator' => '/'],
                'mg' => ['rate' => 1e-6, 'operator' => '/'],
                't' => ['rate' => 1e-15, 'operator' => '*'],
                'µg' => ['rate' => 0.001, 'operator' => '/'],
                'kt' => ['rate' => 1e-18, 'operator' => '*']
            ],

            // Volume
            'L' => [
                'mL' => ['rate' => 1000, 'operator' => '*'],
                'm³' => ['rate' => 0.001, 'operator' => '*'],
                'cm³' => ['rate' => 1000, 'operator' => '*'],
                'km³' => ['rate' => 1e-12, 'operator' => '*'],
                'mm³' => ['rate' => 1_000_000, 'operator' => '*'],
                'nL' => ['rate' => 1e+9, 'operator' => '*'],
                'pL' => ['rate' => 1e+12, 'operator' => '*'],
                'µL' => ['rate' => 1e+6, 'operator' => '*'],
                'daL' => ['rate' => 0.1, 'operator' => '*'],
                'hL' => ['rate' => 0.01, 'operator' => '*'],
                'dam³' => ['rate' => 1e-6, 'operator' => '*'],
                'hm³' => ['rate' => 1e-9, 'operator' => '*'],
                'km³' => ['rate' => 1e-15, 'operator' => '*']
            ],
            'mL' => [
                'L' => ['rate' => 0.001, 'operator' => '/'],
                'm³' => ['rate' => 1e-6, 'operator' => '*'],
                'cm³' => ['rate' => 1, 'operator' => '*'],
                'km³' => ['rate' => 1e-15, 'operator' => '*'],
                'mm³' => ['rate' => 1000, 'operator' => '*'],
                'nL' => ['rate' => 1e+6, 'operator' => '*'],
                'pL' => ['rate' => 1e+9, 'operator' => '*'],
                'µL' => ['rate' => 1000, 'operator' => '*'],
                'daL' => ['rate' => 1e-4, 'operator' => '*'],
                'hL' => ['rate' => 1e-5, 'operator' => '*'],
                'dam³' => ['rate' => 1e-9, 'operator' => '*'],
                'hm³' => ['rate' => 1e-12, 'operator' => '*'],
                'km³' => ['rate' => 1e-18, 'operator' => '*']
            ],
            'm³' => [
                'L' => ['rate' => 1000, 'operator' => '*'],
                'mL' => ['rate' => 1e+6, 'operator' => '*'],
                'cm³' => ['rate' => 1e+6, 'operator' => '*'],
                'km³' => ['rate' => 1e-9, 'operator' => '*'],
                'mm³' => ['rate' => 1e+9, 'operator' => '*'],
                'nL' => ['rate' => 1e+12, 'operator' => '*'],
                'pL' => ['rate' => 1e+15, 'operator' => '*'],
                'µL' => ['rate' => 1e+9, 'operator' => '*'],
                'daL' => ['rate' => 100, 'operator' => '*'],
                'hL' => ['rate' => 10, 'operator' => '*'],
                'dam³' => ['rate' => 1e-3, 'operator' => '*'],
                'hm³' => ['rate' => 1e-6, 'operator' => '*'],
                'km³' => ['rate' => 1e-9, 'operator' => '*']
            ],
            'cm³' => [
                'L' => ['rate' => 0.001, 'operator' => '/'],
                'mL' => ['rate' => 1, 'operator' => '*'],
                'm³' => ['rate' => 1e-6, 'operator' => '*'],
                'km³' => ['rate' => 1e-15, 'operator' => '*'],
                'mm³' => ['rate' => 1000, 'operator' => '*'],
                'nL' => ['rate' => 1e+6, 'operator' => '*'],
                'pL' => ['rate' => 1e+9, 'operator' => '*'],
                'µL' => ['rate' => 1000, 'operator' => '*'],
                'daL' => ['rate' => 1e-4, 'operator' => '*'],
                'hL' => ['rate' => 1e-5, 'operator' => '*'],
                'dam³' => ['rate' => 1e-9, 'operator' => '*'],
                'hm³' => ['rate' => 1e-12, 'operator' => '*'],
                'km³' => ['rate' => 1e-18, 'operator' => '*']
            ],
            'km³' => [
                'L' => ['rate' => 1e+12, 'operator' => '*'],
                'mL' => ['rate' => 1e+15, 'operator' => '*'],
                'cm³' => ['rate' => 1e+15, 'operator' => '*'],
                'm³' => ['rate' => 1e+9, 'operator' => '*'],
                'mm³' => ['rate' => 1e+18, 'operator' => '*'],
                'nL' => ['rate' => 1e+21, 'operator' => '*'],
                'pL' => ['rate' => 1e+24, 'operator' => '*'],
                'µL' => ['rate' => 1e+15, 'operator' => '*'],
                'daL' => ['rate' => 1e+10, 'operator' => '*'],
                'hL' => ['rate' => 1e+11, 'operator' => '*'],
                'dam³' => ['rate' => 1e+6, 'operator' => '*'],
                'hm³' => ['rate' => 1e+9, 'operator' => '*'],
                'km³' => ['rate' => 1, 'operator' => '*']
            ],
            'mm³' => [
                'L' => ['rate' => 1e-6, 'operator' => '/'],
                'mL' => ['rate' => 1e-3, 'operator' => '/'],
                'cm³' => ['rate' => 1e-3, 'operator' => '/'],
                'm³' => ['rate' => 1e-9, 'operator' => '/'],
                'km³' => ['rate' => 1e-18, 'operator' => '/'],
                'nL' => ['rate' => 1e-9, 'operator' => '/'],
                'pL' => ['rate' => 1e-12, 'operator' => '/'],
                'µL' => ['rate' => 1e-6, 'operator' => '/'],
                'daL' => ['rate' => 1e-7, 'operator' => '/'],
                'hL' => ['rate' => 1e-8, 'operator' => '/'],
                'dam³' => ['rate' => 1e-12, 'operator' => '/'],
                'hm³' => ['rate' => 1e-15, 'operator' => '/'],
                'km³' => ['rate' => 1e-21, 'operator' => '/']
            ],
            'nL' => [
                'L' => ['rate' => 1e-9, 'operator' => '/'],
                'mL' => ['rate' => 1e-6, 'operator' => '/'],
                'cm³' => ['rate' => 1e-6, 'operator' => '/'],
                'm³' => ['rate' => 1e-12, 'operator' => '/'],
                'km³' => ['rate' => 1e-21, 'operator' => '/'],
                'mm³' => ['rate' => 1e-9, 'operator' => '/'],
                'pL' => ['rate' => 1e-3, 'operator' => '/'],
                'µL' => ['rate' => 1e-9, 'operator' => '/'],
                'daL' => ['rate' => 1e-10, 'operator' => '/'],
                'hL' => ['rate' => 1e-11, 'operator' => '/'],
                'dam³' => ['rate' => 1e-15, 'operator' => '/'],
                'hm³' => ['rate' => 1e-18, 'operator' => '/'],
                'km³' => ['rate' => 1e-24, 'operator' => '/']
            ],
            'pL' => [
                'L' => ['rate' => 1e-12, 'operator' => '/'],
                'mL' => ['rate' => 1e-9, 'operator' => '/'],
                'cm³' => ['rate' => 1e-9, 'operator' => '/'],
                'm³' => ['rate' => 1e-15, 'operator' => '/'],
                'km³' => ['rate' => 1e-24, 'operator' => '/'],
                'mm³' => ['rate' => 1e-12, 'operator' => '/'],
                'nL' => ['rate' => 1e-3, 'operator' => '/'],
                'µL' => ['rate' => 1e-12, 'operator' => '/'],
                'daL' => ['rate' => 1e-13, 'operator' => '/'],
                'hL' => ['rate' => 1e-14, 'operator' => '/'],
                'dam³' => ['rate' => 1e-19, 'operator' => '/'],
                'hm³' => ['rate' => 1e-22, 'operator' => '/'],
                'km³' => ['rate' => 1e-30, 'operator' => '/']
            ],

            // Panjang
            'm' => [
                'cm' => ['rate' => 100, 'operator' => '*'],
                'mm' => ['rate' => 1000, 'operator' => '*'],
                'km' => ['rate' => 0.001, 'operator' => '*'],
                'nm' => ['rate' => 1e+9, 'operator' => '*'],
                'dam' => ['rate' => 0.1, 'operator' => '*'],
                'hm' => ['rate' => 0.01, 'operator' => '*']
            ],
            'cm' => [
                'm' => ['rate' => 0.01, 'operator' => '/'],
                'mm' => ['rate' => 10, 'operator' => '*'],
                'km' => ['rate' => 1e-5, 'operator' => '*'],
                'nm' => ['rate' => 1e+7, 'operator' => '*'],
                'dam' => ['rate' => 0.001, 'operator' => '*'],
                'hm' => ['rate' => 1e-4, 'operator' => '*']
            ],
            'mm' => [
                'm' => ['rate' => 0.001, 'operator' => '/'],
                'cm' => ['rate' => 0.1, 'operator' => '/'],
                'km' => ['rate' => 1e-6, 'operator' => '*'],
                'nm' => ['rate' => 1e+6, 'operator' => '*'],
                'dam' => ['rate' => 1e-4, 'operator' => '*'],
                'hm' => ['rate' => 1e-5, 'operator' => '*']
            ],
            'km' => [
                'm' => ['rate' => 1000, 'operator' => '*'],
                'cm' => ['rate' => 1e+5, 'operator' => '*'],
                'mm' => ['rate' => 1e+6, 'operator' => '*'],
                'nm' => ['rate' => 1e+12, 'operator' => '*'],
                'dam' => ['rate' => 100, 'operator' => '*'],
                'hm' => ['rate' => 10, 'operator' => '*']
            ],
            'nm' => [
                'm' => ['rate' => 1e-9, 'operator' => '/'],
                'cm' => ['rate' => 1e-7, 'operator' => '/'],
                'mm' => ['rate' => 1e-6, 'operator' => '/'],
                'km' => ['rate' => 1e-12, 'operator' => '/'],
                'dam' => ['rate' => 1e-10, 'operator' => '/'],
                'hm' => ['rate' => 1e-11, 'operator' => '/']
            ],
            'dam' => [
                'm' => ['rate' => 10, 'operator' => '*'],
                'cm' => ['rate' => 1000, 'operator' => '*'],
                'mm' => ['rate' => 10_000, 'operator' => '*'],
                'km' => ['rate' => 0.0001, 'operator' => '*'],
                'nm' => ['rate' => 1e+8, 'operator' => '*'],
                'hm' => ['rate' => 0.1, 'operator' => '*']
            ],
            'hm' => [
                'm' => ['rate' => 100, 'operator' => '*'],
                'cm' => ['rate' => 10_000, 'operator' => '*'],
                'mm' => ['rate' => 100_000, 'operator' => '*'],
                'km' => ['rate' => 0.01, 'operator' => '*'],
                'nm' => ['rate' => 1e+11, 'operator' => '*'],
                'dam' => ['rate' => 10, 'operator' => '*']
            ]
        ];


        collect($conversionRates)->each(function ($rates, $fromUnit) {
            collect($rates)->each(function ($rate, $toUnit) use ($fromUnit) {
                echo "Creating conversion from $fromUnit to $toUnit\n";
                UnitConversion::create([
                    'from_unit_id' => Unit::where('symbol', $fromUnit)->first()->id,
                    'to_unit_id' => Unit::where('symbol', $toUnit)->first()->id,
                    'conversion_rate' => $rate['rate'],
                    'operator' => $rate['operator']
                ]);
            });
        });

    }
}
