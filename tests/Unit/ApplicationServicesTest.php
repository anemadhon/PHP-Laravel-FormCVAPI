<?php

namespace Tests\Unit;

use App\Models\AvailableJob;
use App\Models\City;
use App\Models\Country;
use App\Services\ApplicationServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationServicesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_payload_prepared_before_store_to_db()
    {
        $fakeRequest = [
            'available_job_id' => 1,
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'email@email.net',
            'phone' => '081336363259',
            'nationality' => 'indonesia',
            'driving_license' => '081336363259',
            'birth_place' => 'bandung',
            'birth_date' => 1645549200,
            'country_id' => 1,
            'city_id' => 1,
            'address' => 'my address',
            'postal_code' => 15233,
        ];
        $payload = (new ApplicationServices())->payloadPreparetion($fakeRequest);

        $this->assertArrayHasKey('user', $payload);
        $this->assertArrayHasKey('first_name', $payload['user']);
        $this->assertArrayHasKey('address', $payload['user_home']);
        $this->assertArrayHasKey('available_job_id', $payload['application']);
    }

    public function test_data_stored_to_db()
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
        $payload = (new ApplicationServices())->payloadPreparetion($fakeRequest);
        $application = (new ApplicationServices())->storeToDB($payload);

        $this->assertTrue(isset($application->code));
    }
    
    public function test_data_updated()
    {
        $availableJob = AvailableJob::factory(2)->create();
        $country = Country::factory()->create();
        $city = City::factory()->create();
        $fakeRequest = [
            'available_job_id' => $availableJob->first()->id,
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
        $fakeRequestUpdate = [
            'available_job_id' => $availableJob->last()->id,
            'first_name' => 'first UP',
            'last_name' => 'last',
            'email' => 'email@email.net',
            'phone' => '081336363259',
            'nationality' => 'indonesia',
            'driving_license' => '081336363259',
            'birth_place' => 'bandung',
            'birth_date' => 1645549200,
            'country_id' => $country->id,
            'city_id' => $city->id,
            'address' => 'my address Up',
            'postal_code' => 15233,
        ];
        $payload = (new ApplicationServices())->payloadPreparetion($fakeRequest);
        $payloadUpdate = (new ApplicationServices())->payloadPreparetion($fakeRequestUpdate);
        $application = (new ApplicationServices())->storeToDB($payload);
        $updatedApplication = (new ApplicationServices())->updateData($payloadUpdate, $application->load(['user', 'user.home']));

        $this->assertEquals($application->code, $updatedApplication->code);
        $this->assertEquals($availableJob->last()->id, $updatedApplication->available_job_id);
        $this->assertEquals($fakeRequestUpdate['first_name'], $updatedApplication->load('user')->user->first_name);
        $this->assertEquals($fakeRequestUpdate['address'], $updatedApplication->load(['user', 'user.home'])->user->home->address);
    }
}
