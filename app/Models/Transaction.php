<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    const WITHDRAW = 'withdraw';
    const DEPOSIT = 'deposit';
    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'fee',
        'date',
    ];

    /*=== Scope Start ===*/
    /**
     * get all deposit
     * @param Builder $query
     * @return Builder
     */
    public function scopeDeposit(Builder $query): Builder
    {
        return $query->whereTransactionType(self::DEPOSIT);
    }
    /**
     * get all withdraw
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithdraw(Builder $query): Builder
    {
        return $query->whereTransactionType(self::WITHDRAW);
    }
    /*=== Scope End ===*/
}
