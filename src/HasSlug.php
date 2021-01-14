<?php

namespace Spatie\Tags;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::saving(function (Model $model) {
            $model->slug = \Str::slug($model->name);
        });
    }

    protected function generateSlug(string $locale): string
    {
        return \Str::slug($this->name);
    }
}
