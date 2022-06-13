<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->get();

        return Inertia::render('Wallets', [
            'wallets' => $wallets,
        ]);
    }

    public function show($id)
    {
        $wallet = Wallet::find($id);
        if (!$wallet)
            abort(404);

        return Inertia::render('WalletDetail', [
            'wallet' => $wallet,
        ]);
    }

    public function update($id, Request $request)
    {
        $wallet = Wallet::find($id);
        if (!$wallet)
            abort(404);

        $wallet->update([
            'name' => $request->name,
            'amount' => (int) str_replace(',', '', $request->amount),
        ]);

        return redirect()->back()->with('success', 'Wallet updated');
    }
}
