<?php

namespace App\Models;

use App\Dictionary\SearchFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revenue extends Model implements SearchFields
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'product_id', 'total', 'date'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Relation to product
     *
     * @return BelongsTo
     */
    public function product (): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation to client
     *
     * @return BelongsTo
     */
    public function client (): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
