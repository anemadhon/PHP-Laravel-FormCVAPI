<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetWorkHistoryResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'employer' => $this->employer,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'city' => $this->city->name,
            'description' => $this->birth_place,
        ];
    }
}
