<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nev
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
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'munkakor', 'nev');
    }
}
