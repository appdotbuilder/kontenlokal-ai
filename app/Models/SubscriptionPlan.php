<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscriptionPlan
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property float $price_monthly
 * @property float $price_yearly
 * @property int $credits_monthly
 * @property array $features
 * @property int $max_team_members
 * @property bool $is_popular
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan whereIsPopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan active()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPlan popular()
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class SubscriptionPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'credits_monthly',
        'features',
        'max_team_members',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'features' => 'array',
        'credits_monthly' => 'integer',
        'max_team_members' => 'integer',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include popular plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Get formatted monthly price in IDR.
     */
    public function getFormattedMonthlyPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_monthly, 0, ',', '.');
    }

    /**
     * Get formatted yearly price in IDR.
     */
    public function getFormattedYearlyPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_yearly, 0, ',', '.');
    }

    /**
     * Calculate yearly savings percentage.
     */
    public function getYearlySavingsPercentageAttribute(): int
    {
        if ($this->price_monthly <= 0) {
            return 0;
        }

        $monthlyTotal = $this->price_monthly * 12;
        $savings = $monthlyTotal - $this->price_yearly;
        
        return (int) round(($savings / $monthlyTotal) * 100);
    }
}