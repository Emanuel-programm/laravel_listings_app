<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    // add mass assignable fields
    protected $fillable = [
        'user_id',
        'job_id',
        'full_name',
        'contact_phone',
        'contact_email',
        'message',
        'location',
        'resume_path',

    ];


    //    Relatoonship to job
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    //    Relationship to user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
