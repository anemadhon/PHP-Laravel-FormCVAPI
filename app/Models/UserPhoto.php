<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';

    const CREATED_AT = false;
    const UPDATED_AT = 'uploaded_at';

    protected $fillable = ['base_64_photo', 'uploaded_at'];
    protected $casts = [
        'uploaded_at' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
