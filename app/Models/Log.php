<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'company_id',
        'user_id',
        'action',
        'type',
        'object',
        'geolocation',
        'platform',
        'device',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function _user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
