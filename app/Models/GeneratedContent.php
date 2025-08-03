<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\GeneratedContent
 *
 * @property int $id
 * @property int $user_id
 * @property int $content_type_id
 * @property string $title
 * @property array $input_data
 * @property string|null $generated_content
 * @property string $status
 * @property string|null $error_message
 * @property int $credits_used
 * @property string|null $ai_model_used
 * @property float|null $processing_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\ContentType $contentType
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent completed()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedContent pending()
 * @method static \Database\Factories\GeneratedContentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class GeneratedContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'content_type_id',
        'title',
        'input_data',
        'generated_content',
        'status',
        'error_message',
        'credits_used',
        'ai_model_used',
        'processing_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'input_data' => 'array',
        'credits_used' => 'integer',
        'processing_time' => 'decimal:2',
    ];

    /**
     * Get the user that owns the generated content.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the content type for this generated content.
     */
    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }

    /**
     * Scope a query to only include completed content.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending content.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if content generation is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if content generation failed.
     */
    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Mark content as processing.
     */
    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    /**
     * Mark content as completed.
     */
    public function markAsCompleted(string $content, string $aiModel = null, float $processingTime = null): void
    {
        $this->update([
            'status' => 'completed',
            'generated_content' => $content,
            'ai_model_used' => $aiModel,
            'processing_time' => $processingTime,
        ]);
    }

    /**
     * Mark content as failed.
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }
}