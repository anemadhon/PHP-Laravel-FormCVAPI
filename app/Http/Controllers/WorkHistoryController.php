<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkHistoryRequest;
use App\Http\Resources\DMLQueryResource;
use App\Http\Resources\GetWorkHistoryResource;
use App\Models\Application;
use App\Services\WorkHistoryServices;
use Illuminate\Http\Request;

class WorkHistoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        string $code, 
        WorkHistoryRequest $request, 
        WorkHistoryServices $historyServices
    ){
        $application = $historyServices->storeToDB($code, $request->validated());

        return DMLQueryResource::make($application);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $employment)
    {
        $workHistories = $employment->load([
            'user', 
            'user.workHistories', 
            'user.workHistories.city'
        ])->user->workHistories;

        return GetWorkHistoryResource::collection($workHistories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request, 
        Application $employment, 
        WorkHistoryServices $historyServices
    ){
        $result = $historyServices->deleteData($employment, (int)$request->query('id'));

        return DMLQueryResource::make($result);
    }
}
