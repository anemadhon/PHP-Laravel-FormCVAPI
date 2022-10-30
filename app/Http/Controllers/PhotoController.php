<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Services\PhotoServices;
use App\Http\Requests\PhotoRequest;
use App\Http\Resources\DMLQueryResource;

class PhotoController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $photo)
    {
        $photo64 = $photo->load([
            'user:id,application_id', 
            'user.photo'
        ])->user->photo->base_64_photo;

        return response()->json([
            'data' => [
                'base_64_photo' => $photo64
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
        PhotoRequest $request, 
        Application $photo, 
        PhotoServices $photoServices
    ){
        $uploadedPhoto = $photoServices->upload($photo, $request->validated());

        return response()->json([
            'data' => [
                'code' => $photo->code,
                'url' => $uploadedPhoto
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $photo, PhotoServices $photoServices)
    {
        $result = $photoServices->deleteData($photo);

        return DMLQueryResource::make($result);
    }
}
