<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Position;
use App\Models\ShiftTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Admin::create([
            'fullname' => 'Rahmat',
            'username' => 'admin',
            'password' => bcrypt('qazwsx')
        ]);

        Position::factory(8)->create();
        Employee::factory(20)->create();

        ShiftTime::create([
            'name' => 'Pagi',
            'from' => Carbon::parse('08:00'),
            'until' => Carbon::parse('17:00')
        ]);

        ShiftTime::create([
            'name' => 'Malam',
            'from' => Carbon::parse('17:00'),
            'until' => Carbon::parse('22:00')
        ]);

    }
}
