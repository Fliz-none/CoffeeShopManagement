<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transactions';
    protected $appends = ['code', 'paymentStr', 'statusStr'];
    protected $fillable = [
        'company_id',
        'order_id',
        'customer_id',
        'cashier_id',
        'payment',
        'amount',
        'date',
        'note',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function _order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }

    public function _customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withTrashed();
    }

    public function _cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id')->withTrashed();
    }

    public function getPaymentStrAttribute()
    {
        switch (true) {
            case $this->payment == '0':
                $result = 'Tiền mặt';
                break;
            case $this->payment == '1':
                $result = 'Chuyển khoản';
                break;
            default:
                $result = 'Không xác định';
                break;
        }
        return $result;
    }

    public function getFullAmountAttribute()
    {
        if ($this->amount > 0) {
            $result = '<a class="text-success" data-bs-toggle="tooltip" data-bs-title="' . $this->statusStr . '">+' . number_format($this->amount) . 'đ</a>';
        } elseif ($this->amount < 0) {
            $result = '<a class="text-danger" data-bs-toggle="tooltip" data-bs-title="' . $this->statusStr . '">' . number_format($this->amount) . 'đ</a>';
        } else {
            $result = number_format($this->amount);
        }
        return $result;
    }

    public function getStatusStrAttribute()
    {
        if ($this->amount > 0) {
            $result = 'Thanh toán';
        } else {
            $result = 'Hoàn tiền';
        }
        return $result;
    }

    public function getCodeAttribute()
    {
        return 'GD' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
