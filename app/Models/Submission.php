<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Submission extends Model
{
    /** @use HasFactory<SubmissionFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'new',
        'answers' => '[]',
        'files' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'status' => SubmissionStatus::class,
            'birthday' => 'date',
            'answers' => 'array',
            'files' => 'array',
        ];
    }

    public function submittable(): MorphTo
    {
        return $this->morphTo();
    }
}
