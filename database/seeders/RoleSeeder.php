<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'operational']);
        Role::create(['name' => 'human-resource']);
        Role::create(['name' => 'counter']);

        $module = [
            'position',
            'shift',
            'employee',
            'attendance',
            'salary',
            'delivery-order'
        ];

        foreach($module as $m){
            Permission::create(['name' => $m]);
        }

    }
}
