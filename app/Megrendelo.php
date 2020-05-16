<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $kiszallito_id
 * @property string $nev
 * @property string $telefonszam
 * @property string $szallitasi_cim
 * @property boolean $szepkartya
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property MegrendeloHet[] $megrendeloHetek
 */
class Megrendelo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'megrendelok';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['kiszallito_id', 'nev', 'telefonszam', 'szallitasi_cim', 'szepkartya', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'kiszallito_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function megrendeloHetek()
    {
        return $this->hasMany('App\MegrendeloHet', 'megrendelo_id');
    }
}
