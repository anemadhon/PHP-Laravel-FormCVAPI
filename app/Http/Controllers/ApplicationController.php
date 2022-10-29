<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\DMLQueryResource;
use App\Http\Resources\GetProfileResource;
use App\Models\Application;
use App\Services\ApplicationServices;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::with([
            'availableJob', 
            'user', 
            'user.home', 
            'user.home.country', 
            'user.home.city', 
            'user.photo'
        ])->get();

        return GetProfileResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        ApplicationRequest $request, 
        ApplicationServices $applicationServices
    ){
        $payload = $applicationServices->payloadPreparetion($request->validated());
        $application = $applicationServices->storeToDB($payload);

        return DMLQueryResource::make($application);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $profile)
    {
        return GetProfileResource::make($profile->load([
            'availableJob', 
            'user', 
            'user.home', 
            'user.home.country', 
            'user.home.city', 
            'user.photo'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        ApplicationRequest $request, 
        Application $profile, 
        ApplicationServices $applicationServices
    ){
        $payload = $applicationServices->payloadPreparetion($request->validated());
        $updatedApplication = $applicationServices->updateData($payload, $profile);

        return DMLQueryResource::make($updatedApplication);
    }
}
