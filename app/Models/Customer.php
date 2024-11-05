<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    // Các trường có thể fillable
    protected $fillable = [
        'name',
        'phone',
        'level',
        'company_id',
    ];

    /**
     * Định nghĩa mối quan hệ với model Company
     * Một khách hàng thuộc về một công ty
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Định nghĩa mối quan hệ với model Order
     * Một khách hàng có thể có nhiều đơn hàng
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Định nghĩa mối quan hệ với model Transaction
     * Một khách hàng có thể có nhiều giao dịch
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function getCodeAttribute()
    {
        return 'KH' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
