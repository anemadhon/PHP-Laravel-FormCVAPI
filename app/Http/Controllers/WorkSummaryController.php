<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkSummaryRequest;
use App\Http\Resources\DMLQueryResource;
use App\Models\Application;

class WorkSummaryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $experience)
    {
        $workSummary = $experience->load([
            'user:id,application_id', 
            'user.experienceSummary:user_id,work_summary'
        ])->user
            ->experienceSummary
            ->work_summary;

        return response()->json([
            'data' => [
                'work_summary' => $workSummary
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        WorkSummaryRequest $request, 
        Application $experience
    ){
        $experience->load([
            'user:id,application_id', 
            'user.experienceSummary'
        ])->user
            ->experienceSummary()
            ->updateOrCreate(
                ['user_id' => $experience->user->id], 
                $request->validated()
            );

        return DMLQueryResource::make($experience);
    }
}
