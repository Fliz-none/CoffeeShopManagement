<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Error extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'errors';
    protected $appends = array('code');

    protected $fillable = [
        'branch_id',
        'user_id',
        'action',
        'object',
        'object_id',
        'object_name',
        'description',
    ];

    public function _branch()
    {
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    public function _user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getCodeAttribute()
    {
        return 'ERR' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
