<?php

namespace App\Http\Controllers;

use App\Models\SavingMoney;
use App\Models\SpendingMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $transaction = null;
        switch ($request->type) {
            case "spending":
                $transaction = SpendingMoney::create([
                    'amount' => $request->rawAmount,
                    'user_id' => Auth::user()->id,
                    'description' => $request->description,
                ]);
                break;

            case "saving":
                $transaction = SavingMoney::create([
                    'amount' => $request->rawAmount,
                    'user_id' => Auth::user()->id,
                ]);
                break;
        }

//        return Redirect::route('dashboard');
        return \redirect()->back();
    }
}
