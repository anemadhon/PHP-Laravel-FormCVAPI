<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationRequest;
use App\Http\Resources\GetEducationResource;
use App\Models\Application;
use App\Services\EducationServices;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        string $code, 
        EducationRequest $request, 
        EducationServices $educationService
    ){
        $application = $educationService->storeToDB($code, $request->validated());

        return DMLQueryResource::make($application);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $education)
    {
        $userEducation = $education->load([
            'user', 
            'user.workHistories', 
            'user.workHistories.city'
        ])->user->educations;

        return GetEducationResource::make($userEducation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request, 
        Application $education,
        EducationServices $educationService
    ){
        $result = $educationService->deleteData($education, (int)$request->query('id'));

        return DMLQueryResource::make($result);
    }
}
