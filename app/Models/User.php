<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $dateFormat = 'U';

    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name',
        'email', 'phone', 'birth_date',
        'birth_place', 'nationality',
        'driving_license'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'updated_at' => 'timestamp',
    ];

    public function home()
    {
        return $this->hasOne(UserHome::class);
    }
    
    public function photo()
    {
        return $this->hasOne(UserPhoto::class);
    }
    
    public function experienceSummary()
    {
        return $this->hasOne(UserExperience::class);
    }

    public function workHistories()
    {
        return $this->hasMany(UserWorkHistory::class);
    }
    
    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }
    
    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
