<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sector_id
 * @property int $competence_id
 * @property string $created_at
 * @property string $updated_at
 * @property Competence $competence
 * @property Sector $sector
 */
class SectorCompetence extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sector_id', 'competence_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competence()
    {
        return $this->belongsTo('App\Competence');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }
}
