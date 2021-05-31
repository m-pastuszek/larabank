<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'recipient_name',
        'recipient_address',
        'recipient_iban',
        'sender_name',
        'sender_address',
        'sender_iban',
        'amount',
        'currency'
    ];

    /**
     * Using Laravel accessors to make them visible in Voyager.
     * @var string[]
     */
    public $additional_attributes = ['formatted_amount', 'formatted_sender_iban', 'formatted_recipient_iban'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Transakcja ma jedną operację.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function operation()
    {
        return $this->hasOne(Operation::class);
    }

    /**
     * Accessor zwracający sformatowaną kwotę przelewu.
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        return str_replace('.', ',', sprintf('%0.2f', $this->amount)) . " zł";
    }


    /**
     * Accessor zwracający sformatowany IBAN nadawcy.
     * @return string
     */
    public function getFormattedSenderIbanAttribute()
    {
        $countryCode    = substr( $this->sender_iban, 0, 2);
        $controlNumber  = substr( $this->sender_iban, 2, 2 );
        $bankNumber1    = substr( $this->sender_iban, 4, 4 );
        $bankNumber2    = substr ( $this->sender_iban, 8, 4 );
        $accountNr1     = substr ( $this->sender_iban, 12, 4 );
        $accountNr2     = substr ( $this->sender_iban, 16, 4 );
        $accountNr3     = substr ( $this->sender_iban, 20, 4 );
        $accountNr4     = substr ( $this->sender_iban, 24, 4 );

        return $controlNumber.' '.$bankNumber1.' '.$bankNumber2.' '.$accountNr1.' '.$accountNr2.' '.$accountNr3.' '.$accountNr4;
    }

    /**
     * Accessor zwracający sformatowany IBAN odbiorcy.
     * @return string
     */
    public function getFormattedRecipientIbanAttribute()
    {
        $countryCode    = substr( $this->recipient_iban, 0, 2);
        $controlNumber  = substr( $this->recipient_iban, 2, 2 );
        $bankNumber1    = substr( $this->recipient_iban, 4, 4 );
        $bankNumber2    = substr ( $this->recipient_iban, 8, 4 );
        $accountNr1     = substr ( $this->recipient_iban, 12, 4 );
        $accountNr2     = substr ( $this->recipient_iban, 16, 4 );
        $accountNr3     = substr ( $this->recipient_iban, 20, 4 );
        $accountNr4     = substr ( $this->recipient_iban, 24, 4 );

        return $controlNumber.' '.$bankNumber1.' '.$bankNumber2.' '.$accountNr1.' '.$accountNr2.' '.$accountNr3.' '.$accountNr4;
    }

}
