<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class PhotoServices
{
    public function upload(Application $application, array $request)
    {
        $path = $this->moveToStorage($application->code, $request['base_64_photo']);

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

        $this->deleteFromStorage($application->code, $photo64->base_64_photo);

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

    private function moveToStorage(string $code, string $base64photo)
    {
        $extracted = $this->extractBase64($code, $base64photo);

        Storage::disk('public')->put("upload/photo/{$extracted['filename']}", $extracted['decoded']);

        return Storage::url("upload/photo/{$extracted['filename']}");
    }

    private function deleteFromStorage(string $code, string $base64photo)
    {
        $extracted = $this->extractBase64($code, $base64photo);

        Storage::disk('public')->delete("upload/photo/{$extracted['filename']}");
    }

    private function extractBase64(string $code, string $base64photo)
    {
        $toGetExtension = explode('data:image/', $base64photo)[1];
        $photoExtension = explode(';base64,', $toGetExtension);
        $photoName = "{$code}-photos.{$photoExtension[0]}";
        $decodedPhoto = base64_decode($photoExtension[1]);

        return [
            'filename' => $photoName,
            'decoded' => $decodedPhoto
        ];
    }
}
