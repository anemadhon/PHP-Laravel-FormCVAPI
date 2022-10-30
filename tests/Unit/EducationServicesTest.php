<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\City;
use App\Models\Country;
use App\Models\AvailableJob;
use App\Services\EducationServices;
use App\Services\ApplicationServices;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EducationServicesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_education_user_to_db()
    {
        $availableJob = AvailableJob::factory()->create();
        $country = Country::factory()->create();
        $city = City::factory()->create();
        $fakeRequest = [
            'available_job_id' => $availableJob->id,
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'email@email.net',
            'phone' => '081336363259',
            'nationality' => 'indonesia',
            'driving_license' => '081336363259',
            'birth_place' => 'bandung',
            'birth_date' => 1645549200,
            'country_id' => $country->id,
            'city_id' => $city->id,
            'address' => 'my address',
            'postal_code' => 15233,
        ];
        $fakeRequestForEducation = [
            'school' => 'ITB',
            'degree' => 'S1',
            'start_date' => 1645549200,
            'end_date' => 1645549200,
            'city_id' => $city->id,
            'description' => 'ITB',
        ];
        $payload = (new ApplicationServices())->payloadPreparetion($fakeRequest);
        $application = (new ApplicationServices())->storeToDB($payload);
        $educationData = (new EducationServices())->storeToDB($application->code, $fakeRequestForEducation);

        $this->assertEquals($application->code, $educationData->code);
        $this->assertEquals($application->load(['user', 'user.educations'])->user->educations->first()->id, $educationData->id);
    }

    public function test_delete_education_user()
    {
        $availableJob = AvailableJob::factory()->create();
        $country = Country::factory()->create();
        $city = City::factory()->create();
        $fakeRequest = [
            'available_job_id' => $availableJob->id,
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'email@email.net',
            'phone' => '081336363259',
            'nationality' => 'indonesia',
            'driving_license' => '081336363259',
            'birth_place' => 'bandung',
            'birth_date' => 1645549200,
            'country_id' => $country->id,
            'city_id' => $city->id,
            'address' => 'my address',
            'postal_code' => 15233,
        ];
        $fakeRequestForEducation = [
            'school' => 'ITB',
            'degree' => 'S1',
            'start_date' => 1645549200,
            'end_date' => 1645549200,
            'city_id' => $city->id,
            'description' => 'ITB',
        ];
        $payload = (new ApplicationServices())->payloadPreparetion($fakeRequest);
        $application = (new ApplicationServices())->storeToDB($payload);
        $educationData = (new EducationServices())->storeToDB($application->code, $fakeRequestForEducation);
        $deleted = (new EducationServices())->deleteData($application, $educationData->id);

        $this->assertEquals($educationData->code, $deleted->code);
        $this->assertEquals($educationData->id, $deleted->id);
    }
}
