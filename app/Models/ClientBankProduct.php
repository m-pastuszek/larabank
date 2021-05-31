<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBankProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iban',
        'balance',
        'panel_color',
        'bank_product_id',
        'user_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_bank_products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Using Laravel accessors to make them visible in Voyager.
     * @var string[]
     */
    public $additional_attributes = ['formatted_iban', 'balance_french_notation'];

    public function bankProduct()
    {
        return $this->belongsTo(BankProduct::class, 'bank_product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function getBalanceFrenchNotationAttribute()
    {
        return number_format($this->balance, 2, ',', ' ') . " zł";
    }

    public function getFormattedIbanAttribute()
    {
        $countryCode    = substr( $this->iban, 0, 2);
        $controlNumber  = substr( $this->iban, 2, 2 );
        $bankNumber1    = substr( $this->iban, 4, 4 );
        $bankNumber2    = substr ( $this->iban, 8, 4 );
        $accountNr1     = substr ( $this->iban, 12, 4 );
        $accountNr2     = substr ( $this->iban, 16, 4 );
        $accountNr3     = substr ( $this->iban, 20, 4 );
        $accountNr4     = substr ( $this->iban, 24, 4 );

        return $controlNumber.' '.$bankNumber1.' '.$bankNumber2.' '.$accountNr1.' '.$accountNr2.' '.$accountNr3.' '.$accountNr4;
    }
}
