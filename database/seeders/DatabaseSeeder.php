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
            'phone' => '0123456789',
            'password' => 'test',
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
        // Trip::create([
        //     'id' => 1,
        //     'code' => 'FP 2100',
        //     'from'
        // ])
    }
}
