<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sector_id
 * @property int $role
 * @property int $user_responsable_id
 * @property int $game_status
 * @property string $name
 * @property string $password
 * @property string $description
 * @property string $image
 * @property string $idea_title
 * @property string $idea_description
 * @property string $idea_needs
 * @property string $idea_value
 * @property string $idea_clients
 * @property string $comment_validation
 * @property string $type
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property Sector $sector
 * @property User $user
 * @property Log[] $logs
 * @property UserItem[] $userItems
 */
class User extends Authenticatable implements JWTSubject
{
    /**
     * @var array
     */
    protected $fillable = ['sector_id', 'user_responsable_id', 'role', 'name', 'password', 'description', 'image', 'idea_title', 'idea_description', 'idea_needs', 'idea_value', 'idea_clients', 'game_status', 'comment_validation', 'type', 'remember_token', 'created_at', 'updated_at'];

    use Notifiable;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_responsable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userItems()
    {
        return $this->hasMany('App\UserItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'user_responsable_id', 'id');
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($pass){
        $this->attributes['password'] = bcrypt($pass);
    }
}
