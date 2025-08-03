<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentCalendar
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $event_date
 * @property string $event_name
 * @property string $event_type
 * @property string $description
 * @property array $content_ideas
 * @property array|null $hashtags
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar active()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCalendar upcoming()
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ContentCalendar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'event_date',
        'event_name',
        'event_type',
        'description',
        'content_ideas',
        'hashtags',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',
        'content_ideas' => 'array',
        'hashtags' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_calendar';

    /**
     * Scope a query to only include active calendar entries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include upcoming events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    /**
     * Get formatted hashtags as string.
     */
    public function getHashtagsStringAttribute(): string
    {
        if (!$this->hashtags) {
            return '';
        }

        return implode(' ', array_map(fn($tag) => '#' . $tag, $this->hashtags));
    }
}