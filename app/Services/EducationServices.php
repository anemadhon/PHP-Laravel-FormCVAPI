<?php 

namespace App\Services;

use App\Models\Application;

class EducationServices
{
    public function storeToDB(string $code, array $request)
    {
        $application = Application::where('code', $code)->first();

        $education = $application->load([
            'user', 
            'user.educations'
        ])->user
            ->educations()
            ->create($request);

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $education->id]);
    }

    public function deleteData(Application $application, int $id)
    {
        $application->load(['user', 'user.educations'])
            ->user
            ->educations()
            ->where('id', $id)
            ->delete();

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $id]);
    }
}
