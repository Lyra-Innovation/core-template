<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $question_id
 * @property string $answer
 * @property boolean $correct
 * @property string $created_at
 * @property string $updated_at
 * @property Question $question
 */
class Answer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['question_id', 'answer', 'correct', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
