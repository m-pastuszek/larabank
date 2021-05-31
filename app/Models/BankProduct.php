<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankProduct extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bank_products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $guarded = [];

    /**
     * Bank product belongs to type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(BankProductType::class, 'id');
    }

    /**
     * Bank Products can have many client bank products.
     * (One user can have 2 normal bank accounts).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientBankProducts()
    {
        return $this->hasMany(ClientBankProduct::class);
    }
}
