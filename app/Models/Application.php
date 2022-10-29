<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    const CREATED_AT = 'applied_at';
    const UPDATED_AT = false;

    public $timestamps = false;

    protected $fillable = [
        'available_job_id',
        'candidate_id',
        'code', 'applied_at'
    ];

    protected $cast = [
        'applied_at' => 'timestamp'
    ];

    public function availableJob()
    {
        return $this->belongsTo(AvailableJob::class);
    }
}
