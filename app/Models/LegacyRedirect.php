<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegacyRedirect extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'old_path',
        'new_path',
        'status_code',
        'notes',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function setOldPathAttribute(?string $value): void
    {
        $this->attributes['old_path'] = self::normalizeOldPath($value);
    }

    public function setNewPathAttribute(?string $value): void
    {
        $this->attributes['new_path'] = self::normalizeNewPath($value);
    }

    private static function normalizeOldPath(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return trim((string) $value, "/ \t\n\r\0\x0B");
    }

    private static function normalizeNewPath(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim((string) $value);

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return '/'.trim($value, "/ \t\n\r\0\x0B");
    }
}
