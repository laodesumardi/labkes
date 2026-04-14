<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::set('app_name', 'Laboratorium Kesehatan', 'text', 'general');
        Setting::set('primary_color', '#004b23', 'text', 'appearance');
    }
}
