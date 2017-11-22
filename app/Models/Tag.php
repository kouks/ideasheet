<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Specifies the belongs to many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ideas()
    {
        return $this->belongsToMany(Idea::class);
    }

    /**
     * This method makes sure that we only create those tags that are not
     * already created.
     *
     * @param  array  $tags
     * @return \Illuminate\Support\Collection
     */
    public static function createNew($tags)
    {
        return collect($tags)->map(function ($tag) {
            return static::firstOrCreate(['name' => $tag]);
        });
    }
}
