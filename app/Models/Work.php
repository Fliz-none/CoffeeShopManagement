<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Work extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'works';
    protected $appends = array('thumb');
    protected $fillable = [
        'user_id', 'status', 'img', 'note', 'company_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getThumbAttribute()
    {
        $path = 'public/checkin/' . $this->img;
        if (Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/checkin/' . $this->img);
        } else {
            $image = asset('/storage/placeholder.png');
        }
        return $image;
    }
}
