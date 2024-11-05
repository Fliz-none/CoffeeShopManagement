<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $fillable = [
        'user_id',
        'company_id',
        'branch_id',
        'start_time',
        'end_time',
        'slot',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCodeAttribute()
    {
        return 'SCHE' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
