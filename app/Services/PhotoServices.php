<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PhotoServices
{
    public function upload(Application $application, array $request)
    {
        $path = $this->moveToStorage($request['base_64_photo']);
        $this->storeToDB($application, $request);

        return $path;
    }

    public function deleteData(Application $application)
    {
        $photo64 = $application->load([
            'user:id,application_id', 
            'user.photo'
        ])->user->photo;

        $photo64ID = $photo64->id;

        $photo64->delete();

        return (new UtilServices())->convertToJson(['code' => $application->code, 'id' => $photo64ID]);
    }

    private function storeToDB(Application $application, array $request)
    {
        $application->load([
            'user:id,application_id', 
            'user.photo'
        ])->user
            ->photo()
            ->updateOrCreate(
                ['user_id' => $application->user->id], 
                $request
            );
    }

    private function moveToStorage(string $base64photo)
    {
        $toGetExtension = explode('data:image/', $base64photo)[1];
        $photoExtension = explode(';base64,', $toGetExtension);
        $photoName = Str::random(15).'.'.$photoExtension[0];

        Storage::disk('public')->put("upload/photo/{$photoName}", base64_decode($photoExtension[1]));

        return Storage::url("upload/photo/{$photoName}");
    }
}
