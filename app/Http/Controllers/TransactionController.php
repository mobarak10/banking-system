<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositeStoreRequest;
use App\Http\Requests\WithdrawStoreRequest;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->paginate(24)
            ->withQueryString();

        return view('transaction.index', compact('transactions'));
    }

    public function allDeposit()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->deposit()
            ->paginate(24)
            ->withQueryString();

        return view('transaction.deposit.index', compact('transactions'));
    }

    public function allWithdraw()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->withdraw()
            ->paginate(24)
            ->withQueryString();

        return view('transaction.withdraw.index', compact('transactions'));
    }

    public function createDeposit()
    {
        return view('transaction.deposit.create');
    }

    public function storeDeposit(DepositeStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['transaction_type'] = 'deposit';
        $data['date'] = date('Y-m-d');

        DB::beginTransaction();

        try {
            Auth::user()->increment('balance', $data['amount']);
            DB::table('transactions')->insert($data);

            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Deposit added successfully');
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function createWithdraw()
    {
        $account_type = Auth::user()->account_type;
        return view('transaction.withdraw.create', compact('account_type'));
    }

    public function storeWithdraw(WithdrawStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['transaction_type'] = 'withdraw';
        $data['date'] = date('Y-m-d');
        $data['fee'] = $this->getFee($data['user_id'], $request->input('amount'));

        $total_withdraw = $request->input('amount') + $data['fee'];
        $total_balance = Auth::user()->balance;

        if ($total_withdraw > $total_balance) {
            $withdraw_amount = $total_balance - $data['fee'];
            return redirect()->back()->withErrors("You can't withdraw more than $withdraw_amount");
        }

        DB::beginTransaction();

        try {
            Auth::user()->decrement('balance', ($data['amount'] + $data['fee']));
            DB::table('transactions')->insert($data);
            DB::commit();
            return redirect()->route('transaction.index')->with('success', 'Withdraw added successfully');
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getFee($user_id, $amount)
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $user = User::with('transactions')->find($user_id);
        $total_withdraw = $user->transactions()->where('transaction_type', 'withdraw')->sum('amount');
        $this_month_withdraw = $user->transactions()
            ->where('transaction_type', 'withdraw')
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');

        if ($user->account_type === 'individual') {
            $day = Carbon::now()->englishDayOfWeek;
            if ($day === 'Friday') {
                return 0;
            }elseif ($this_month_withdraw < 5000) {
                $total_this_month_withdraw = $this_month_withdraw + $amount;
                if ($total_this_month_withdraw > 5000) {
                    return ($total_this_month_withdraw - 5000) - (($total_this_month_withdraw - 5000) - (0.015 * 100));
                }
            }
            elseif ($total_withdraw < 1000) {
                $total_this_month_withdraw = $total_withdraw + $amount;
                if ($total_this_month_withdraw > 1000) {
                    return ($total_this_month_withdraw - 1000) - (($total_this_month_withdraw - 1000) - (0.015 * 100));
                }
            }else{
                return ($amount) - (($amount) - (0.015 * 100));
            }
        }else{
            if ($total_withdraw > 50000) {
                return ($amount) - (($amount) - (0.015 * 100));
            }else{
                return ($amount) - (($amount) - (0.025 * 100));
            }
        }
        return 0;
    }
}
