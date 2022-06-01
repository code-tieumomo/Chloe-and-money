<?php

namespace App\Http\Controllers;

use App\Models\SavingMoney;
use App\Models\SpendingMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $savingMoney = SavingMoney::where('user_id', Auth::user()->id)->get();
        $spendingMoney = SpendingMoney::where('user_id', Auth::user()->id)->get();

        return Inertia::render('Dashboard', [
            'savingMoney' => $savingMoney,
            'spendingMoney' => $spendingMoney,
            'isReady' => $savingMoney->count() > 0 || $spendingMoney->count() > 0,
        ]);
    }
}
