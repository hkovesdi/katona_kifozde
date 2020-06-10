<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $megrendelo_id
 * @property integer $het_start_datum_id
 * @property string $fizetesi_mod
 * @property string $fizetve_at
 * @property string $created_at
 * @property string $updated_at
 * @property FizetesiModok $fizetesiModok
 * @property Datumok $datumok
 * @property Megrendelok $megrendelok
 */
class MegrendeloHet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'megrendelok_hetek';

   // protected $appends = ['osszeg'];

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['megrendelo_id', 'het_start_datum_id', 'megjegyzes', 'fizetesi_mod', 'fizetve_at', 'created_at', 'updated_at'];


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
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function megrendelesek()
    {
        return $this->hasMany('App\Megrendeles', 'megrendelo_het_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datum()
    {
        return $this->belongsTo('App\Datum', 'het_start_datum_id');
    }

    /**
     * Visszaadja a heti rendelések összegét
     */
   // public function getOsszegAttribute() {
     //   return $this->megrendelesek->sum(function($megrendeles) {
       //     return $megrendeles->feladag ? $megrendeles->tetel->ar*0.6 : $megrendeles->tetel->ar;
        //});
    //}
}
