<?php

namespace App\Models;

use App\Enum\ProfileStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property ProfileStatus $status
 * @property int $creator_id
 * @property string $image_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property User $creator
 * @property Collection<Comment> $comments
 */
class Profile extends Model
{
    /**
     * @var array<int,string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => ProfileStatus::class,
    ];

    /**
     * Get the user that created the profile.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the comments for the profile.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
