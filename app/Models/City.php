<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, Sluggable;
    
    public $timestamp = false;
    
    protected $fillable = ['country_id', 'name', 'slug'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
