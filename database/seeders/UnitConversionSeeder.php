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
                'Kg' => ['rate' => 0.001, 'operator' => '*'],  // Perbaikan dari '/'
                'mg' => ['rate' => 1000, 'operator' => '*'],
                't' => ['rate' => 1e-6, 'operator' => '*'],
                'µg' => ['rate' => 1_000_000, 'operator' => '*'],
                'pg' => ['rate' => 1_000_000_000, 'operator' => '*'],
                'kt' => ['rate' => 1e-9, 'operator' => '*']
            ],
            'mg' => [
                'Kg' => ['rate' => 1e-6, 'operator' => '*'],  // Perbaikan dari '/'
                'g' => ['rate' => 0.001, 'operator' => '*'],  // Perbaikan dari '/'
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
            'µg' => [
                'Kg' => ['rate' => 1e-9, 'operator' => '*'],  // Perbaikan dari '/'
                'g' => ['rate' => 1e-6, 'operator' => '*'],   // Perbaikan dari '/'
                'mg' => ['rate' => 0.001, 'operator' => '*'], // Perbaikan dari '/'
                't' => ['rate' => 1e-12, 'operator' => '*'],
                'pg' => ['rate' => 1000, 'operator' => '*'],
                'kt' => ['rate' => 1e-15, 'operator' => '*']
            ],
            'pg' => [
                'Kg' => ['rate' => 1e-12, 'operator' => '*'], // Perbaikan dari '/'
                'g' => ['rate' => 1e-9, 'operator' => '*'],   // Perbaikan dari '/'
                'mg' => ['rate' => 1e-6, 'operator' => '*'],  // Perbaikan dari '/'
                't' => ['rate' => 1e-15, 'operator' => '*'],
                'µg' => ['rate' => 0.001, 'operator' => '*'], // Perbaikan dari '/'
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
                'L' => ['rate' => 0.001, 'operator' => '*'], // Perbaikan dari '/'
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
                'L' => ['rate' => 0.001, 'operator' => '*'], // Perbaikan dari '/'
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
