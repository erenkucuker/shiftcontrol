<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateScheduleRequest;
use Spatie\QueryBuilder\{QueryBuilder,AllowedFilter,AllowedSort};
use App\Models\{Schedule,User};


class EmployeeController extends Controller
{
    public function storeSchedule(CreateScheduleRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';
        if($user->schedule()->where('start_time', $data['start_time'])->get()->count()  > 0) 
        {
            return $this->conflictApiResponse($data,'You already created a schedule request with given time');
        }
        
        $user->schedule()->create($data);
        return $this->createdApiResponse($data,  'Schedule request created successfully');
        
    }

    public function showSchedules()
    {
        
        $schedules = QueryBuilder::for(Schedule::class)
        ->allowedFilters([
            AllowedFilter::scope('starts_between'),
        ])
        ->get()->toArray();
        
        return $this->successApiResponse($schedules);
    
    }
    public function indexSchedules()
    {
        $schedules = QueryBuilder::for(Schedule::class)            
            ->with('user','user.job')
            ->get()->toArray();
        return $this->successApiResponse($schedules);
    }
}
