<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Job};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Events\ScheduleCreated;
class Schedule extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',      
        'start_time',
        'end_time',
        'status',
        'created_at',
        'updated_at'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeStartsBetween(Builder $query, $start_time, $end_time): Builder
    {
        return $query->whereBetween('start_time', [Carbon::parse($start_time), Carbon::parse($end_time)]);
    }
    public function scopeStatus(Builder $query, $value): Builder
    {
        return $query->where('status','=', $value);
    }
    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            ScheduleCreated::dispatch($item);
        });
    
    }
}
