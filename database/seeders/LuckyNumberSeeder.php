<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Registration;

class LuckyNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Registration::orderBy('id')->chunk(100, function ($registrations) {
            foreach ($registrations as $registration) {
                // assume 'count' is numeric (or castable); adjust if it's zero-padded
                $registration->lucky_number = ((int) $registration->count) + 1000;
                $registration->saveQuietly();
            }
        });
    }
}
