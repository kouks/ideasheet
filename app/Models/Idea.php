<?php

namespace App\Models;

use Koch\Casters\Behavior\Castable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\PaginatesResults;

class Idea extends Model
{
    use Castable, PaginatesResults;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'color', 'query', 'featured',
    ];

    /**
     * Specifies the belongs to relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Specifies the has many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Specifies the belongs to many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
