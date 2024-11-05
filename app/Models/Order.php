<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $appends = ['code', 'statusStr', 'total', 'totalAdditions', 'paid'];
    protected $fillable = [
        'company_id',
        'branch_id',
        'room_id',
        'customer_id',
        'dealer_id',
        'method',
        'discount',
        'checkout_at',
        'status',
        'note',
    ];

    public function getTotalAdditionsAttribute()
    {
        $baseTotal = $this->details->sum('price');
        $totalDiscounts = $this->additions()
            ->where('type', 0)
            ->sum('amount');
        $totalSurcharges = $this->additions()
            ->where('type', 1)
            ->sum('amount');
        if ($totalSurcharges < 100) {
            $totalSurcharges = ($baseTotal * $totalSurcharges) / 100;
        }
        if ($totalDiscounts < 100) {
            $totalDiscounts = ($baseTotal * $totalDiscounts) / 100;
        }
        return $totalSurcharges - $totalDiscounts;
    }

    public function getPaidAttribute()
    {
        $paid = ($this->transactions->count()) ? $this->transactions->sum('amount') : 0;
        return $paid;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function _customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withTrashed();
    }

    public function _dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id')->withTrashed();
    }


    public function _branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function additions()
    {
        return $this->hasMany(Addition::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTotalAttribute() //Tính tổng chưa giảm
    {
        return $this->details->sum('price') + $this->totalAdditions;
    }

    public function getCodeAttribute()
    {
        return 'DH' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '3':
                $result = 'Hoàn thành';
                break;
            case '2':
                $result = 'Đang xử lý';
                break;
            case '0':
                $result = 'Bị hủy';
                break;
            default:
                $result = 'Không xác định';
                break;
        }
        return $result;
    }



    public function assignTable($table)
    {
        $result = DB::table('order_table')->insert([
            'order_id' => $this->id,
            'table_id' => $table
        ]);
        return $result;
    }

    public function syncTables($tables)
    {
        if (DB::table('order_table')->where('order_id', $this->id)->count()) {
            $delete = DB::table('order_table')->where('order_id', $this->id)->delete();
        } else {
            $delete = true;
        }
        if ($delete) {
            if (isset($tables[0])) {
                foreach ($tables as $key => $table) {
                    $this->assignTable($table);
                }
            }
            return true;
        } else {
            return false;
        }
    }

}
