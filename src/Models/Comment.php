<?php

namespace Rubik\LaravelComments\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rubik\LaravelComments\Traits\HasComments;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasComments;

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get all approved comments
     *
     * @param $query
     * @return mixed
     */
    public function scopeApproved($query): Builder
    {
        return $query->whereNotNull('approved_at')->orWhere('needs_approval', false);
    }

    /**
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo
     */
    public function commenter(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Approve a comment
     *
     * @param string|Carbon|null $date
     * @param bool $overwrite
     * @return Comment
     */
    public function approve(string|Carbon $date = null, bool $overwrite = false): Comment
    {
        if ($this->approved_at && $overwrite === false) {
            return $this;
        }

        if ($date instanceof Carbon) {
            $this->update([
                'approved_at' => $date,
            ]);

            return $this;
        }

        if ($date) {
            $this->update([
                'approved_at' => Carbon::parse($date),
            ]);

            return $this;
        }

        $this->update([
            'approved_at' => Carbon::now(),
        ]);

        return $this;
    }

    /**
     * Disapprove a comment
     *
     * @return $this
     */
    public function disapprove(): Comment
    {
        $this->approved_at = null;

        $this->save();

        return $this;
    }

    /**
     * Determine if a comment is approved
     *
     * @return bool
     */
    public function getIsApprovedAttribute(): bool
    {
        return ! ! $this->approved_at || ! $this->needs_approval;
    }
}
