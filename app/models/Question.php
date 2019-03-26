<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $question
 * @property string $created_at
 * @property string $updated_at
 * @property Answer[] $answers
 */
class Question extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['question', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
