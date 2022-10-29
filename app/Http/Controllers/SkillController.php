<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Services\SkillServices;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\DMLQueryResource;
use App\Http\Resources\GetSkillResource;

class SkillController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        string $code, 
        SkillRequest $request, 
        SkillServices $skillServices
    ){
        $application = $skillServices->storeToDB($code, $request->validated());

        return DMLQueryResource::make($application);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $skill)
    {
        $userSkills = $skill->load([
            'user', 
            'user.skills', 
            'user.skills.skill'
        ])->user->skills;

        return GetSkillResource::collection($userSkills);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request, 
        Application $skill, 
        SkillServices $skillServices
    ){
        $result = $skillServices->deleteData($skill, (int)$request->query('id'));

        return DMLQueryResource::make($result);
    }
}
