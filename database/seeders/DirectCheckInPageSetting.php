<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectCheckInPageSetting extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $site_setting = SiteSetting::create([
            'page_title' => 'directCheckIn',
        ]);
        $site_setting->copyMedia(public_path('assets/frontend/images/check-in.jpg'))->toMediaCollection('images');
    }
}
