<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'applied_job' => $this->availableJob->name,
            'user' => [
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'birth_place' => $this->user->birth_place,
                'birth_date' => $this->user->birth_date,
                'nationality' => $this->user->nationality,
                'driving_license' => $this->user->driving_license,
                'home' => [
                    'address' => $this->user->home->address,
                    'postal_code' => $this->user->home->postal_code,
                    'country' => $this->user->home->country->name,
                    'city' => $this->user->home->city->name,
                ],
                'photo' => [
                    'mime_types' => '',
                    'url' => ''
                ],
            ]
        ];
    }
}
