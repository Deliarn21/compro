<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    use HasFactory;

    public const TYPE_PAGE = 'page';
    public const TYPE_MILESTONE = 'milestone';
    public const TYPE_EXECUTIVE = 'executive';
    public const TYPE_BUSINESS_UNIT = 'business_unit';
    public const TYPE_BUSINESS_ENTITY = 'business_entity';
    public const TYPE_CSR_PILLAR = 'csr_pillar';
    public const TYPE_PUBLICATION = 'publication';
    public const TYPE_LOCATION = 'location';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'category',
        'parent_id',
        'title',
        'slug',
        'subtitle',
        'summary',
        'body',
        'image_path',
        'link_url',
        'meta_title',
        'meta_description',
        'legacy_path',
        'extra',
        'sort_order',
        'is_published',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('title');
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $builder): void {
                $builder->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('published_at')->orderBy('title');
    }

    public function scopePages(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_PAGE);
    }

    public function scopeMilestones(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_MILESTONE);
    }

    public function scopeExecutives(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_EXECUTIVE);
    }

    public function scopeBusinessUnits(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_BUSINESS_UNIT);
    }

    public function scopeBusinessEntities(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_BUSINESS_ENTITY);
    }

    public function scopeCsrPillars(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_CSR_PILLAR);
    }

    public function scopePublications(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_PUBLICATION);
    }

    public function scopeLocations(Builder $query): Builder
    {
        return $query->ofType(self::TYPE_LOCATION);
    }

    public function extraValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->extra, $key, $default);
    }

    public function hasCategory(string $category): bool
    {
        return $this->category === $category;
    }
}
