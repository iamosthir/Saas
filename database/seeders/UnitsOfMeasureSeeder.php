<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Manufacturing\UnitOfMeasure;
use Illuminate\Database\Seeder;

class UnitsOfMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds default units of measure for all merchants with manufacturing permission.
     */
    public function run(): void
    {
        $units = [
            // Weight units
            ['name' => 'Kilogram', 'symbol' => 'kg', 'category' => 'weight', 'is_base_unit' => true, 'conversion_factor' => 1],
            ['name' => 'Gram', 'symbol' => 'g', 'category' => 'weight', 'is_base_unit' => false, 'conversion_factor' => 0.001],
            ['name' => 'Ton', 'symbol' => 'ton', 'category' => 'weight', 'is_base_unit' => false, 'conversion_factor' => 1000],
            ['name' => 'Pound', 'symbol' => 'lb', 'category' => 'weight', 'is_base_unit' => false, 'conversion_factor' => 0.453592],
            ['name' => 'Ounce', 'symbol' => 'oz', 'category' => 'weight', 'is_base_unit' => false, 'conversion_factor' => 0.0283495],
            ['name' => 'Milligram', 'symbol' => 'mg', 'category' => 'weight', 'is_base_unit' => false, 'conversion_factor' => 0.000001],

            // Volume units
            ['name' => 'Liter', 'symbol' => 'L', 'category' => 'volume', 'is_base_unit' => true, 'conversion_factor' => 1],
            ['name' => 'Milliliter', 'symbol' => 'ml', 'category' => 'volume', 'is_base_unit' => false, 'conversion_factor' => 0.001],
            ['name' => 'Gallon', 'symbol' => 'gal', 'category' => 'volume', 'is_base_unit' => false, 'conversion_factor' => 3.78541],
            ['name' => 'Cubic Meter', 'symbol' => 'm³', 'category' => 'volume', 'is_base_unit' => false, 'conversion_factor' => 1000],
            ['name' => 'Fluid Ounce', 'symbol' => 'fl oz', 'category' => 'volume', 'is_base_unit' => false, 'conversion_factor' => 0.0295735],

            // Length units
            ['name' => 'Meter', 'symbol' => 'm', 'category' => 'length', 'is_base_unit' => true, 'conversion_factor' => 1],
            ['name' => 'Centimeter', 'symbol' => 'cm', 'category' => 'length', 'is_base_unit' => false, 'conversion_factor' => 0.01],
            ['name' => 'Millimeter', 'symbol' => 'mm', 'category' => 'length', 'is_base_unit' => false, 'conversion_factor' => 0.001],
            ['name' => 'Inch', 'symbol' => 'in', 'category' => 'length', 'is_base_unit' => false, 'conversion_factor' => 0.0254],
            ['name' => 'Foot', 'symbol' => 'ft', 'category' => 'length', 'is_base_unit' => false, 'conversion_factor' => 0.3048],

            // Count/Piece units
            ['name' => 'Piece', 'symbol' => 'pcs', 'category' => 'piece', 'is_base_unit' => true, 'conversion_factor' => 1],
            ['name' => 'Dozen', 'symbol' => 'doz', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 12],
            ['name' => 'Box', 'symbol' => 'box', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 1],
            ['name' => 'Carton', 'symbol' => 'ctn', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 1],
            ['name' => 'Pack', 'symbol' => 'pack', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 1],
            ['name' => 'Can', 'symbol' => 'can', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 1],
            ['name' => 'Bottle', 'symbol' => 'btl', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 1],
            ['name' => 'Bag', 'symbol' => 'bag', 'category' => 'piece', 'is_base_unit' => false, 'conversion_factor' => 1],
        ];

        // Get all merchants with manufacturing permission
        $merchants = Merchant::where('can_access_manufacturing', true)->get();

        foreach ($merchants as $merchant) {
            foreach ($units as $unit) {
                UnitOfMeasure::firstOrCreate(
                    [
                        'symbol' => $unit['symbol'],
                        'merchant_id' => $merchant->id
                    ],
                    array_merge($unit, ['merchant_id' => $merchant->id])
                );
            }
        }

        $this->command->info('Units of measure seeded for ' . $merchants->count() . ' merchants with manufacturing permission.');
    }
}
