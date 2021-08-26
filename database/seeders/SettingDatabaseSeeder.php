<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setting::setMany([
            'default_local' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'supported_currencies' => ['LE','SAR','USD'],
            'default_currency' => 'USD',
            'store_email' => 'leadermatrix@yahoo.com',
            'search_engine' => 'mysql',
            'local_shipping_cost' => 0,
            'outer_shipping_cost' => 0,
            'free_shipping_cost' => 0,
            'translatable' => [
                'store_name' => 'Walid Store',
                'free_shipping_label' => 'Free shipping',
                'local_label' => 'local shipping',
                'outer_label' => 'outer shipping',
            ],
        ]);
    }
}
