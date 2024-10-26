<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $theme_id
 * @property string $content
 * @property boolean $is_blocked
 * @property string $blocked_reason
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Theme $theme
 * @property User $user
 */
class Message extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'theme_id', 'content', 'is_blocked', 'blocked_reason'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Theme');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
