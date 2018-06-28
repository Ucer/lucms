<?php

namespace App\Models\Traits;

trait ScopeTrait
{
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeEnable($query)
    {
        return $query->where('enable', 'T');
    }

    public function scopeEnableSearch($query, $value)
    {
        return $query->where('enable', $value);
    }

    public function scopeColumnLike($query, $column, $value)
    {
        return $query->where($column, 'like', $value . '%');
    }
}
