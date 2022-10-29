<?php 

namespace App\Services;

class UtilServices
{
    public function convertToJson(array $data)
    {
        return json_decode(json_encode($data));
    }
}
