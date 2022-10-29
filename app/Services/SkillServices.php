<?php 

namespace App\Services;

use App\Models\Application;

class SkillServices
{
    public function storeToDB(string $code, array $request)
    {
        $application = Application::where('code', $code)->first();

        $skill = $application->load([
            'user', 
            'user.skills'
        ])->user
            ->skills()
            ->create($request);

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $skill->id]);
    }

    public function deleteData(Application $application, int $id)
    {
        $application->load(['user', 'user.skills'])
            ->user
            ->skills()
            ->where('id', $id)
            ->delete();

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $id]);
    }
}
