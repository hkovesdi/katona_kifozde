<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nev
 * @property int $privilege_level
 * @property User[] $users
 */
class Munkakor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'munkakorok';

    public $timestamps = false;

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'nev';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nev', 'privilege_level'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'munkakor', 'nev');
    }
}
