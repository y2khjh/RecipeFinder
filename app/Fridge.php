<?php

namespace RecipeFinder;

use Illuminate\Database\Eloquent\Model;

class Fridge extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fridges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item', 'amount', 'unit', 'use_by'];


    public function scopeAllUsable($query)
    {
        return $query->where('use_by', '>', date('d/m/Y'));
    }

    public function scopeInStock($query, $amount, $unit)
    {
        return $query->where('amount', '>=', $amount)->whereUnit($unit);
    }
}
