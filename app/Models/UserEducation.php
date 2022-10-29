<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;

    protected $table = 'user_educations';
    protected $dateFormat = 'U';

    const CREATED_AT = 'added_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'city_id', 'school', 'degree',
        'start_date', 'end_date',
        'description', 'added_at'
    ];

    protected $casts = [
        'added_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
