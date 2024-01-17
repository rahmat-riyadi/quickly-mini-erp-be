<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Counter;
use App\Models\Employee;
use App\Models\Position;
use App\Models\ShiftTime;
use App\Models\User;
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

        $this->call(RoleSeeder::class);
        $this->call(ItemGroupSeeder::class);

        
        Counter::factory(5)->create();
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

        $user = User::create([
            'username' => 'rahmat.riyadi',
            'password' => bcrypt('qazwsx'),
        ]);

        $user->employee()->create([
            'name' => 'Rahmat Riyadi Syam',
            'position_id' => Position::inRandomOrder()->first('id')->id,
            'nik' => '-',
            'kk' => '-',
            'address' => fake()->address,
            'date_of_birth' => Carbon::now(),
            'place_of_birth' => '-',
            'entry_date' => Carbon::now(),
            'username' => 'rahmat.riyadi',
            'password' => bcrypt('qazwsx'),
            'phone' => fake()->phoneNumber,
            'status' => true
        ]);

        $user->assignRole('operational');
        $user->assignRole('human-resource');

        $user = User::create([
            'username' => 'counter',
            'password' => bcrypt('qazwsx'),
        ]);

        $user->counter()->create([
            'name' => 'counter 1',
            'code' => '01',
            'phone' => fake()->phoneNumber
        ]);

        $user->assignRole('counter');

    }
}
