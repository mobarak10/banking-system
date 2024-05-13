<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::addTotalDeposit()
            ->addTotalWithdraw()
            ->findOrFail(Auth::id());

        return view('dashboard', compact('user'));
    }
}
