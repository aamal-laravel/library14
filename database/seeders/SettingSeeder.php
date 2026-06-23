<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insert([
            [
                'name' => 'max_borrow_books',
                'value' => '3',
            ],
            [
                'name' => 'borrow_days',
                'value' => '14',
            ],
            [
                'name' => 'late_fee_per_day',
                'value' => '0.1',
            ],
            [
                'name' => 'deposit_ratio',
                'value' => '1.5',
            ],
        ]);
    }
}
