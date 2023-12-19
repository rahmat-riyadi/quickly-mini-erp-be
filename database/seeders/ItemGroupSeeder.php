<?php

namespace Database\Seeders;

use App\Imports\ItemGroupImport;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ItemGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Excel::import(new ItemGroupImport, public_path('assets/file/item_group.csv'), readerType: \Maatwebsite\Excel\Excel::CSV);

        $data = DB::connection('mysql_2')->table('item_categories')->get();

        foreach($data as $d){
            
            ItemCategory::insert([
                'id' => $d->id,
                'name' => $d->name,
            ]);
        }

        $data = DB::connection('mysql_2')->table('items')->get();

        foreach($data as $d){
            Item::insert((array)$d);
        }



    }
}
