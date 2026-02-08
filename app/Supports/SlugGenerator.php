<?php

namespace App\Supports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlugGenerator
{
    public function generate(string $value): string
    {
        return Str::of($value)
            ->lower()
            ->ascii()
            ->replaceMatches('/[^a-z0-9]+/', '-')
            ->trim('-')
            ->toString();
    }

    public function generateUnique(string $value, string $table, string $column = 'slug'): string
    {
        $slug = $this->generate($value);
        $original = $slug;
        $count = 1;

        while (
            DB::table($table)
            ->where($column, $slug)
            ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}
