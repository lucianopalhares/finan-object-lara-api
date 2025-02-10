<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bank_transactions';

    /**
     * Custom alias for logging.
     *
     * @var string
     */
    public $logAlias = 'Transação Bancária';

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'bank_account_id',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function getUsernameAttribute()
    {
        return $this->user ? $this->user->name : '';
    }
}
