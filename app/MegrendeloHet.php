<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $het_id
 * @property integer $megrendelo_id
 * @property boolean $fizetett
 * @property boolean $szepkartya
 * @property string $created_at
 * @property string $updated_at
 * @property Het $het
 * @property Megrendelo $megrendelo
 * @property MegrendeloHetTetelek[] $megrendeloHetTeteleks
 */
class MegrendeloHet extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'megrendelok_hetek';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['het_id', 'megrendelo_id', 'fizetett', 'szepkartya', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function het()
    {
        return $this->belongsTo('App\Het', 'het_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function megrendelo()
    {
        return $this->belongsTo('App\Megrendelo', 'megrendelo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function megrendeloHetTetelek()
    {
        return $this->hasMany('App\MegrendeloHetTetel', 'megrendelo_het_id');
    }
}
