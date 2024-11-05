<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $appends = array('statusStr', 'code');
    protected $fillable = [
        'company_id',
        'name',
        'note',
        'price',
        'start_time',
        'end_time',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '2':
                $status = '<span class="text-danger">Đang có khách</span>';
                break;
            case '1':
                $status = '<span class="text-primary">Đã được đặt</span>';
                break;
            default:
                $status = '<span class="text-success">Đang trống</span>';
                break;
        }
        return $status;
    }

    public function getCodeAttribute()
    {
        return 'P' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
