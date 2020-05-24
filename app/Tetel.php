<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $tetel_nev
 * @property integer $datum_id
 * @property string $leiras
 * @property int $ar
 * @property string $created_at
 * @property string $updated_at
 * @property Datum $datumok
 * @property TetelNev $tetelNev
 * @property Megrendel[] $megrendelesek
 */
class Tetel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tetelek';

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
    protected $fillable = ['tetel_nev', 'datum_id', 'leiras', 'ar', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datum()
    {
        return $this->belongsTo('App\Datum', 'datum_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tetelNev()
    {
        return $this->belongsTo('App\TetelNev', 'tetel_nev', 'nev');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function megrendelesek()
    {
        return $this->hasMany('App\Megrendeles', 'tetel_id');
    }

    public function getDayOfWeekAttribute() {
        return $this->datum->day_of_week;
    }

    public function getWeekOfYearAttribute() {
        return $this->datum->week_of_year;
    }
    
    public function getYearAttribute() {
        return $this->datum->year;
    }
}
