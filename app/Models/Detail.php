<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'details';
    protected $appends = ['total'];
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price', 'note'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function getTotalAttribute() //Tính tổng chưa giảm
    {
        return $this->price * $this->quantity;
    }
}
