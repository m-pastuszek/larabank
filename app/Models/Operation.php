<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operation_type_id',
        'from_bank_account_id',
        'to_bank_account_id',
        'transaction_id',
        'scheduled_at',
        'status_id'
    ];

    protected $casts = [
        'scheduled_at' => 'date:Y-m-d',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operations';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OperationType::class, 'operation_type_id');
    }

    public function fromClientBankAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClientBankProduct::class, 'from_bank_account_id');
    }

    public function toClientBankAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClientBankProduct::class, 'to_bank_account_id');
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OperationStatus::class, 'status_id');
    }


}
