<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'Euro',
                'slug' => Str::slug('Euro'),
                'icon' => 'bi-currency-euro'
            ],
            [
                'name' => 'USD',
                'slug' => Str::slug('USD'),
                'icon' => 'bi-currency-dollar'
            ]
        ];
        Currency::insert($currencies);
    }
}
