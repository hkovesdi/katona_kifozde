<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $megrendelo_id
 * @property integer $datum_id
 * @property integer $tetel_id
 * @property string $fizetesi_mod
 * @property bool $feladag
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


    protected $appends = ['day_of_week','week_of_year','year'];

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tetel_id', 'megrendelo_het_id', 'feladag', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tetel()
    {
        return $this->belongsTo('App\Tetel', 'tetel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function megrendeloHet()
    {
        return $this->belongsTo('App\MegrendeloHet', 'megrendelo_het_id');
    }

    public function getDayOfWeekAttribute() {
        return $this->tetel->datum->day_of_week;
    }

    public function getWeekOfYearAttribute() {
        return $this->tetel->datum->week_of_year;
    }
    
    public function getYearAttribute() {
        return $this->tetel->datum->year;
    }
}
