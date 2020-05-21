<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nev
 * @property string $created_at
 * @property string $updated_at
 * @property Megrendeles[] $megrendelesek
 */
class FizetesiMod extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fizetesi_modok';

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
    protected $fillable = ['nev','created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function megrendelesek()
    {
        return $this->hasMany('App\Megrendeles', 'fizetesi_mod', 'nev');
    }
}
