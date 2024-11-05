<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';
    protected $appends = [
        'code',
        'statusStr',
        'favicon_url',
        'logo_horizon_url',
        'logo_square_url',
        'logo_horizon_bw_url',
        'logo_square_bw_url',
    ];

    protected $fillable = [
        'name',
        'deadline',
        'website',
        'contract_total',
        'domain',
        'has_shop',
        'has_revenue',
        'has_attendance',
        'has_account',
        'has_log',
        'address',
        'phone',
        'email',
        'tax_id',
        'status',
        'note',
        'bank_info',
        'standard_attendance_time',
        'max_attendance_time',
        'ip',
        'ip_attendance_required',
        'image_attendance_required',
        'attendance_by_standard_attendance_time',
        'pass_wifi',
        'address',
        'favicon',
        'logo_horizon',
        'logo_square',
        'logo_horizon_bw',
        'logo_square_bw',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function catalogues()
    {
        return $this->hasMany(Catalogue::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getStatusStrAttribute()
    {
        switch (true) {
            case $this->status == '0':
                $result = 'Ngừng hoạt động';
                break;
            case $this->status == '1':
                $result = 'Hoạt động';
                break;
            default:
                $result = 'Khác';
                break;
        }
        return $result;
    }

    public function getFaviconUrlAttribute()
    {
        if (!$this->favicon) {
            return asset('admin/images/logo/favicon_key.png');
        }
        $path = 'public/' . $this->favicon;
        if (Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/' . $this->favicon);
        } else {
            $image = asset('admin/images/logo/favicon_key.png');
        }
        return $image;
    }

    public function getLogoHorizonUrlAttribute()
    {
        if (!$this->logo_horizon) {
            return asset('admin/images/logo/logo_horizon_key.png');
        }
        $path = 'public/' . $this->logo_horizon;
        if (Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/' . $this->logo_horizon);
        } else {
            $image = asset('admin/images/logo/logo_horizon_key.png');
        }
        return $image;
    }

    public function getLogoSquareUrlAttribute()
    {
        if (!$this->logo_square) {
            return asset('admin/images/logo/logo_square.png');
        }
        $path = 'public/' . $this->logo_square;
        if (Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/' . $this->logo_square);
        } else {
            $image = asset('admin/images/logo/logo_square.png');
        }
        return $image;
    }

    public function getLogoHorizonBwUrlAttribute()
    {
        if (!$this->logo_horizon_bw) {
            return asset('admin/images/logo/logo_horizon_bw_key.png');
        }
        $path = 'public/' . $this->logo_horizon_bw;
        if (Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/' . $this->logo_horizon_bw);
        } else {
            $image = asset('admin/images/logo/logo_horizon_bw_key.png');
        }
        return $image;
    }

    public function getLogoSquareBwUrlAttribute()
    {
        if (!$this->logo_square_bw) {
            return asset('admin/images/logo/logo_square_bw_key.png');
        }
        $path = 'public/' . $this->logo_square_bw;
        if (Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/' . $this->logo_square_bw);
        } else {
            $image = asset('admin/images/logo/logo_square_bw_key.png');
        }
        return $image;
    }

    public function getCodeAttribute()
    {
        return 'CT' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
