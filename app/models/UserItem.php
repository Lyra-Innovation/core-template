<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $item
 * @property int $item_id
 * @property string $item_comment
 * @property int $level
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class UserItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'item', 'item_id', 'item_comment', 'level', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
