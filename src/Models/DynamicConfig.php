<?php

namespace zukyDev\DynamicConfig\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DynamicConfig extends Model
{
    public const TYPE_BOOLEAN = 'BOOLEAN';
    public const TYPE_INTEGER = 'INTEGER';
    public const TYPE_FLOAT = 'FLOAT';
    public const TYPE_STRING = 'STRING';
    public const TYPE_DATETIME = 'DATETIME';
    public const TYPE_ENUM = 'ENUM';
    public const TYPE_JSON = 'JSON';

    public const TYPES = [
        self::TYPE_BOOLEAN,
        self::TYPE_INTEGER,
        self::TYPE_FLOAT,
        self::TYPE_STRING,
        self::TYPE_DATETIME,
        self::TYPE_ENUM,
        self::TYPE_JSON,
    ];

    protected array $protected = [];

    public function getValueAttribute(): bool | int | float | string | Object | array | null
    {
        $value = $this->attributes['value'] ?? $this->attributes['default_value'];

        return $this->resolveValue($value);
    }

    public function getDefaultValueAttribute(): bool | int | float | string | Object | array | null
    {
        return $this->resolveValue($this->attributes['default_value']);
    }

    private function resolveValue(?string $value): bool | int | float | string | Object | array | null
    {
        return match ($this->attributes['type']) {
            self::TYPE_BOOLEAN => boolval($value),
            self::TYPE_INTEGER => intval($value),
            self::TYPE_FLOAT => floatval($value),
            self::TYPE_DATETIME => Carbon::parse($value),
            self::TYPE_JSON => json_decode($value),
            self::TYPE_ENUM,
            self::TYPE_STRING => $value,
            default => $value
        };
    }
}
