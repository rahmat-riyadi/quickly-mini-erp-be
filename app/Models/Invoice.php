<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function salesItems(){
        return $this->belongsToMany(SalesItem::class, 'invoices_sales_items', 'invoice_id', 'sales_item_id')
                ->select(['name', 'price'])
                ->withPivot('quantity', 'total');
    }

    public function counter(){
        return $this->belongsTo(Counter::class)->select('id','name', 'code');
    }
}
