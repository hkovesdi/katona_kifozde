<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $megrendelo_id
 * @property integer $datum_id
 * @property integer $tetel_id
 * @property string $fizetesi_mod
 * @property string $created_at
 * @property string $updated_at
 * @property FizetesiMod $fizetesiMod
 * @property Megrendelok $megrendelo
 * @property Tetel $tetel
 */
class Megrendeles extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'megrendelesek';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['megrendelo_id', 'tetel_id', 'fizetesi_mod', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fizetesiMod()
    {
        return $this->belongsTo('App\FizetesiMod', 'fizetesi_mod', 'nev');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function megrendelo()
    {
        return $this->belongsTo('App\Megrendelo', 'megrendelo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tetel()
    {
        return $this->belongsTo('App\Tetel', 'tetel_id');
    }
}
