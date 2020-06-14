<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nev
 * @property string $created_at
 * @property string $updated_at
 * @property Tetel[] $tetelek
 */
class TetelNev extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tetel_nevek';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id';

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
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['nev', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tetelek()
    {
        return $this->hasMany('App\Tetel', 'tetel_nev', 'nev');
    }
}
