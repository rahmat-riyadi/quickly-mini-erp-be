<?php

namespace App\Http\Controllers;

use App\Models\CounterSaleItem;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CounterSaleItemController extends Controller
{
    public function index(){

        $reqToken = request()->header('Authorization');
        $token = PersonalAccessToken::findToken(substr($reqToken, 7));

        $category = request()->query('category');

        $data = CounterSaleItem::
                join('sales_items', 'sales_items.id', '=', 'counter_sale_items.id')
                ->join('sales_item_groups', 'sales_item_groups.id', '=', 'sales_items.sales_item_group_id')
                ->where('counter_id',$token->tokenable->counter_id)
                ->when($category != 'all', function($query) use ($category){
                    $query->where('sales_item_group_id', '=', $category);
                })
                ->get([
                    'counter_sale_items.id',
                    'sales_items.name',
                    'price',
                    'price_2',
                    'counter_sale_items.status',
                    'sales_item_groups.name as category'
                ]);
        return ResponseController::create($data, true, 'get all counter sale item group successfully', 200);
    }

    public function store(Request $request){
        try {
            $data = CounterSaleItem::create($request->all());
            $message = 'create data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }

        return ResponseController::create($data ?? [], $status, $message, $code);
    }

    public function update(Request $request, CounterSaleItem $counterSaleItem){
        try {
            $counterSaleItem->update($request->all());
            $message = 'update data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create($counterSaleItem, $status, $message, $code);
    }

    public function destroy(CounterSaleItem $counterSaleItem){
        try {
            $counterSaleItem->delete();
            $message = 'delete data success';
            $status = true;
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
            $status = false;
        }
        return ResponseController::create(null, $status, $message, $code);
    }
}
