<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';
    protected $appends = ['code', 'fullName', 'statusStr'];

    protected $fillable = [
        'company_id',
        'name',
        'phone',
        'address',
        'note',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->whereNull('info_id');
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                $name = 'Hoạt động';
                break;

            default:
                $name = 'Bị khoá';
                break;
        }
        return $name;
    }

    public function getCodeAttribute()
    {
        return 'CN' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }
}
