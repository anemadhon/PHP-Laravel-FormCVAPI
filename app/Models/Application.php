<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';

    const CREATED_AT = 'applied_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'available_job_id',
        'code', 'applied_at'
    ];

    protected $cast = [
        'applied_at' => 'timestamp'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function availableJob()
    {
        return $this->belongsTo(AvailableJob::class);
    }
}
