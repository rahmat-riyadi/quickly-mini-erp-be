<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class SalesController extends Controller
{
    public function getSalesRecordByCounter(Request $request){
        $reqToken = request()->header('Authorization');
        $token = PersonalAccessToken::findToken(substr($reqToken, 7));
    }

    public function getTodaySalesRecord(){
        $data = Invoice::with('counter')
                ->select('counter_id',DB::raw('SUM(total_price) as total'))
                ->whereDate('created_at', Carbon::now())
                ->groupBy('counter_id')
                ->orderBy('total', 'DESC')
                ->get();

        $dataYesterday = Invoice::with('counter')
            ->select('counter_id', DB::raw('SUM(total_price) as total'))
            ->whereDate('created_at', Carbon::now()->subDay())
            ->groupBy('counter_id')
            ->orderBy('total', 'DESC')
            ->get();

            $combinedData = [];
            foreach ($data as $todayItem) {
                $counterId = $todayItem->counter_id;
                $combinedData[$counterId] = [
                    'counter_id' => $counterId,
                    'total' => $todayItem->total,
                    'yesterday_total' => 0, 
                    'counter' => $todayItem->counter,
                    'difference' => 0,
                ];
            }

            foreach ($dataYesterday as $yesterdayItem) {
                $counterId = $yesterdayItem->counter_id;
                if (isset($combinedData[$counterId])) {
                    $diff = (($combinedData[$counterId]['total'] - $yesterdayItem->total) / $yesterdayItem->total) * 100;
                    $combinedData[$counterId]['difference'] = $diff;
                    $combinedData[$counterId]['yesterday_total'] = $yesterdayItem->total;
                }
            }

            $combinedCollection = collect($combinedData);
            $sortedCombinedCollection = $combinedCollection->sortByDesc('total');
            $result = $sortedCombinedCollection->values();
       
        return ResponseController::create($result, true, 'get sales record success', 200);
    }

    public function getDetailTodaySales($id){

        $data = Invoice::with('salesItems')->where('counter_id', $id)
            ->whereDate('created_at', Carbon::now())
            ->latest()
            ->get();


        return ResponseController::create($data, true, 'get sales record success', 200);

    }

}
