<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property MegrendelokHetek[] $megrendelokHetek
 */
class Het extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hetek';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id','created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function megrendelokHetek()
    {
        return $this->hasMany('App\MegrendelokHetek', 'het_id');
    }
}
