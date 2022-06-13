<?php

namespace App\Http\Controllers;

use App\Models\SavingMoney;
use App\Models\SpendingMoney;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'amount' => (int) str_replace(',', '', $request->amount),
            'sub_group_id' => $request->sub_group_id,
            'date' => $request->date,
            'wallet_id' => $request->wallet_id,
        ]);

        if ($transaction)
            return \redirect()->back()->with('success', 'Transaction stored');
        else
            return \redirect()->back()->withErrors('error', 'Transaction stored');
    }
}
