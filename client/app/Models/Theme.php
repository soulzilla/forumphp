<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $user_id
 * @property integer $status
 * @property boolean $is_blocked
 * @property string $blocked_reason
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Theme extends Model
{
    use AsSource;

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'user_id', 'status', 'is_blocked', 'blocked_reason'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
