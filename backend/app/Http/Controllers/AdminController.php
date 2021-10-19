<?php

namespace App\Http\Controllers;

use Spatie\QueryBuilder\{QueryBuilder, AllowedFilter, AllowedSort};
use App\Models\{Schedule};
use App\Http\Requests\UpdateScheduleRequest;

class AdminController extends Controller
{
    public function indexSchedules()
    {
        $schedules = QueryBuilder::for(Schedule::class)
        ->with('user','user.job')
        ->allowedFilters([
            AllowedFilter::exact('user_id'),
            AllowedFilter::exact('start_time'),
            AllowedFilter::exact('end_time'),
            AllowedFilter::exact('status'),
        ])
        ->get()
        ->toArray();
        ;
        return $this->successApiResponse($schedules);
    }
    public function updateSchedule(UpdateScheduleRequest $request)
    {
        
        $data = $request->validated();
        
        $schedule = Schedule::findOrFail($request->id);
        $schedule->update($data);
        return $this->successApiResponse([],200,'Schedule updated successfully');
    
    }
    
}
