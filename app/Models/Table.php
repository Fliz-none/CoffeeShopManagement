<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'tables';
    protected $appends = array('statusStr', 'code', 'count');
    protected $fillable = [
        'company_id',
        'name',
        'area',
        'note',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '2':
                $status = '<span class="text-primary">Đã được đặt</span>';
                break;
            case '1':
                $status = '<span class="text-danger">Đang có khách</span>';
                break;
            default:
                $status = '<span class="text-success">Đang trống</span>';
                break;
        }
        return $status;
    }

    public function getCodeAttribute()
    {
        return 'B' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getCountAttribute() {
        $count = 0;
        $orders = $this->orders->whereNull('checkout_at');
        if (count($orders) > 0) {
            foreach ($orders as $order) {
                $count += $order->details->sum('quantity');
            }
        }
        return $count;
    }
}
