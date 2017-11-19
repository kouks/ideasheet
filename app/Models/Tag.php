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
     * This method makes sure that we only create those tags that
     * are not already created.
     *
     * Note that I find this method a bit ugly and might rewrite it soon.
     *
     * @param  array  $tags
     * @return \Illuminate\Support\Collection
     */
    public static function createNew($tags)
    {
        $tagInstances = collect([]);

        foreach ($tags as $tagName) {
            $tag = static::where('name', $tagName)->first();

            if (is_null($tag)) {
                $tagInstances->push(static::create(['name' => $tagName]));

                continue;
            }

            $tagInstances->push($tag);
        }

        return $tagInstances;
    }
}
