<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $megrendelo_het_id
 * @property integer $tetel_id
 * @property string $nap
 * @property int $mennyiseg
 * @property string $created_at
 * @property string $updated_at
 * @property MegrendeloHet $megrendelokHet
 * @property Tetel $tetel
 */
class MegrendeloHetTetel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'megrendelo_het_tetelek';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['megrendelo_het_id', 'tetel_id', 'nap', 'mennyiseg', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function megrendeloHet()
    {
        return $this->belongsTo('App\MegrendeloHet', 'megrendelo_het_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tetel()
    {
        return $this->belongsTo('App\Tetel', 'tetel_id');
    }
}
