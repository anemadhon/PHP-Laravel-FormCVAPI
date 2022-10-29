<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';

    const CREATED_AT = 'added_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'skill_id', 'level', 'added_at'
    ];

    protected $casts = [
        'added_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
