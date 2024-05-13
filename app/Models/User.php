<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*=== Relationship Start===*/
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    /*=== Relationship End===*/

    /*=== Scope Start ===*/
    /**
     * get user total deposite
     * @param Builder $query
     * @return Builder
     */
    public function scopeAddTotalDeposit(Builder $query): Builder
    {
        return $query->addSelect([
            'total_deposit' => Transaction::selectRaw('IF (ISNULL(SUM(amount)), 0, SUM(amount))')
                ->whereColumn('transactions.user_id', 'users.id')
                ->where('transactions.transaction_type', 'deposit')
        ]);
    }

    /**
     * get user total withdraw
     * @param Builder $query
     * @return Builder
     */
    public function scopeAddTotalWithdraw(Builder $query): Builder
    {
        return $query->addSelect([
            'total_withdraw' => Transaction::selectRaw('IF (ISNULL(SUM(amount)), 0, SUM(amount))')
                ->whereColumn('transactions.user_id', 'users.id')
                ->where('transactions.transaction_type', 'withdraw')
        ]);
    }

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
