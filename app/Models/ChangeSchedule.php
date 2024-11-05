<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'changeSchedules';

    protected $fillable = [
        'schedule_detail_id',
        'requestor',
        'acceptor',
        'status',
    ];

    public function scheduleDetail()
    {
        return $this->belongsTo(ScheduleDetail::class);
    }

    public function _requestor()
    {
        return $this->belongsTo(User::class, 'requestor')->withTrash();
    }

    public function _acceptor()
    {
        return $this->belongsTo(User::class, 'acceptor')->withTrash();
    }
}
