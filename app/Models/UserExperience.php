<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';

    const CREATED_AT = null;

    protected $fillable = ['work_summary'];
    protected $casts = [
        'updated_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
