<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ApplicationServices
{
    public function payloadPreparetion(array $request): array
    {
        $userPayload = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'nationality' => $request['nationality'],
            'driving_license' => $request['driving_license'],
            'birth_place' => $request['birth_place'],
            'birth_date' => $request['birth_date'],
        ];
        $userHomePayload = [
            'country_id' => $request['country_id'],
            'city_id' => $request['city_id'],
            'address' => $request['address'],
            'postal_code' => $request['postal_code'],
        ];
        $applicationPayload = [
            'available_job_id' => $request['available_job_id'],
            'code' => 'applications-' . Str::random(20)
        ];

        return [
            'user' => $userPayload,
            'user_home' => $userHomePayload,
            'application' => $applicationPayload
        ];
    }

    public function storeToDB(array $payload): Application
    {
        return DB::transaction(function () use ($payload) {
            $application = Application::create($payload['application']);
            $user = $application->load('user')->user()->create($payload['user']);

            $user->load('home')->home()->create($payload['user_home']);

            return $application;
        }, 5);
    }
    
    public function updateData(array $payload, Application $application)
    {
        return DB::transaction(function () use ($payload, $application) {
            $application->update(['available_job_id' => $payload['application']['available_job_id']]);
            $application->user->update($payload['user']);
            $application->user->home->update($payload['user_home']);

            return $application;
        }, 5);
    }
}
