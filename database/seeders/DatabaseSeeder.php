<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cashier;
use App\Models\Counter;
use App\Models\CounterSaleItem;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Position;
use App\Models\SalesItem;
use App\Models\SalesItemGroup;
use App\Models\ShiftTime;
use App\Models\User;
use App\Models\WarehouseItem;
use App\Models\WarehouseItemGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        SalesItemGroup::factory(15)->create();
        WarehouseItemGroup::factory(15)->create();
        WarehouseItem::factory(15)->create();
        Counter::factory(15)->create();
        SalesItem::factory(20)->create();
        CounterSaleItem::factory(20)->create();

        for ($i=1; $i < 4; $i++) { 
            for($n = 1; $n < 11; $n++){
                Invoice::create([
                    'counter_id' => $i,
                    'total_price' => rand(30000, 120000)
                ]);
            }
        }

        $invoices = Invoice::all();

        foreach($invoices as $invoice){

            $totalprice = 0;

            for($i = 1; $i < rand(1,3); $i++){

                $salesItem = SalesItem::inRandomOrder()->first();
                $quantity = rand(1,3);
                $total = $quantity * $salesItem->price;

                DB::table('invoices_sales_items')->insert([
                    'invoice_id' => $invoice->id,
                    'sales_item_id' => $salesItem->id,
                    'quantity' => $quantity,
                    'total' => $total
                ]);

                $totalprice = $totalprice + $total;
            }

            $invoice->update(['total_price' => $totalprice]);

        }

        for ($i=1; $i < 4; $i++) { 
            for($n = 1; $n < 11; $n++){
                Invoice::create([
                    'counter_id' => $i,
                    'total_price' => rand(30000, 120000),
                    'created_at' => Carbon::now()->subDay(),
                    'updated_at' => Carbon::now()->subDay(),
                ]);
            }
        }

        $invoices = Invoice::where('created_at', Carbon::now()->subDay())->get();

        foreach($invoices as $invoice){

            $totalprice = 0;

            for($i = 1; $i < rand(1,3); $i++){

                $salesItem = SalesItem::inRandomOrder()->first();
                $quantity = rand(1,3);
                $total = $quantity * $salesItem->price;

                DB::table('invoices_sales_items')->insert([
                    'invoice_id' => $invoice->id,
                    'sales_item_id' => $salesItem->id,
                    'quantity' => $quantity,
                    'total' => $total,
                    'created_at' => Carbon::now()->subDay(),
                    'updated_at' => Carbon::now()->subDay(),
                ]);

                $totalprice = $totalprice + $total;
            }

            $invoice->update(['total_price' => $totalprice]);

        }


        Cashier::create([
            'username' => 'admin',
            'password' => bcrypt('qazwsx'),
            'counter_id' => 1
        ]);
        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin',
            'password' => bcrypt('qazwsx'),
            'role' => 'superadmin'
        ]);
        User::create([
            'name' => 'operasional',
            'email' => 'operasional',
            'password' => bcrypt('qazwsx'),
            'role' => 'operasional'
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
