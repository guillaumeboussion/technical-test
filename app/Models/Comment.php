<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $content
 * @property int $creator_id
 * @property int $profile_id
 * @property string $created_at
 * @property string $updated_at
 *
 * Relations
 * @property User $creator
 * @property Profile $profile
 */
class Comment extends Model
{
    /**
     * @var array<int,string>
     */
    protected $guarded = ['id'];

    /**
     * Get the user that created the comment.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the profile that the comment belongs to.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
