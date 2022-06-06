<?php

namespace App\Http\Controllers;

use App\Models\SavingMoney;
use App\Models\SpendingMoney;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->get();
        $totalAmount = $wallets->sum('amount');

        return Inertia::render('Dashboard', [
            'wallets' => $wallets,
            'totalAmount' => $totalAmount,
        ]);
    }
}
