<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property SectorCompetence[] $sectorCompetences
 * @property User[] $users
 */
class Sector extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'image', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sectorCompetences()
    {
        return $this->hasMany('App\SectorCompetence');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
