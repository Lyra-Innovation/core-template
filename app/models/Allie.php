<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 */
class Allie extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'image', 'created_at', 'updated_at'];

}
