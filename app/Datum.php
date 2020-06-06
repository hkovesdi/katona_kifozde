<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $datum
 * @property string $created_at
 * @property string $updated_at
 * @property Megrendelesek[] $megrendelesek
 * @property Tetelek[] $tetelek
 */
class Datum extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'datumok';

    public $timestamps = false;

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
    protected $fillable = ['datum', 'het', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function megrendelesek()
    {
        return $this->hasMany('App\Megrendeles', 'datum_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tetelek()
    {
        return $this->hasMany('App\Tetel', 'datum_id');
    }

    public function getDayOfWeekAttribute() {
        return \Carbon\Carbon::parse($this->datum)->dayOfWeek;
    }

    public function getWeekOfYearAttribute() {
        return \Carbon\Carbon::parse($this->datum)->weekOfYear;
    }
    
    public function getYearAttribute() {
        return \Carbon\Carbon::parse($this->datum)->year;
    }
}
