<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Vi',
            'last_name' => 'Os',
            'phone' => '7384932483',
            'password' => 'test',
            'document_number' => '0123456789',
            'birth_date' => '1990-02-20'
        ]);
        Station::create([
            'city' => 'Иркутск',
            'name' => 'Иркутск',
            'code' => '395',
        ]);
        Station::create([
            'city' => 'Братск',
            'name' => 'Братск',
            'code' => '3952',
        ]);
        Trip::create([
            'id' => 2,
            'code' => 'FP 1200',
            'from' => '395',
            'to' => '3952',
            'from_date' => '2021-10-01',
            'from_time' => '12:00',
            'to_date' => '2021-10-01',
            'to_time' => '13:35',
            'cost' => 9500,
            'availability' => 156
        ]);
        Trip::create([
            'id' => 14,
            'code' => 'FP 1201',
            'from' => '395',
            'to' => '3952',
            'from_date' => '2021-10-01',
            'from_time' => '08:35',
            'to_date' => '2021-10-01',
            'to_time' => '10:05',
            'cost' => 10500,
            'availability' => 156
        ]);
        Trip::create([
            'id' => 1,
            'code' => 'FP 2100',
            'from' => '3952',
            'to' => '395',
            'from_date' => '2021-10-10',
            'from_time' => '08:35',
            'to_date' => '2021-10-10',
            'to_time' => '10:05',
            'cost' => 10500,
            'availability' => 156
        ]);
        Trip::create([
            'id' => 13,
            'code' => 'FP 2101',
            'from' => '3952',
            'to' => '395',
            'from_date' => '2021-10-10',
            'from_time' => '12:00',
            'to_date' => '2021-10-10',
            'to_time' => '13:35',
            'cost' => 12500,
            'availability' => 156
        ]);
    }
}
