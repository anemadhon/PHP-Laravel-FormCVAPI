<?php 

namespace App\Services;

use App\Models\Application;

class WorkHistoryServices
{
    public function storeToDB(string $code, array $request)
    {
        $application = Application::where('code', $code)->first();

        $workHistory = $application->load([
            'user', 
            'user.workHistories'
        ])->user
            ->workHistories()
            ->create($request);

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $workHistory->id]);
    }

    public function deleteData(Application $application, int $id)
    {
        $application->load(['user', 'user.workHistories'])
            ->user
            ->workHistories()
            ->where('id', $id)
            ->delete();

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $id]);
    }
}
