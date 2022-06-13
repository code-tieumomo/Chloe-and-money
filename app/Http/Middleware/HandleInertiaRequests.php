<?php

namespace App\Http\Middleware;

use App\Models\Group;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function share(Request $request)
    {
        $groups = Group::with('subGroups')->get();
        $groups = $groups->map(fn($group) => [
            'name' => $group->name,
            'subGroups' => $group->subGroups->map(fn($subGroup) => [
                'id' => $subGroup->id,
                'name' => $subGroup->name,
                'type' => $subGroup->transaction_type,
            ]),
        ]);

        $wallets = $request->user() ? Wallet::where('user_id', Auth::user()->id)->get() : null;

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => [
                    'name' => $request->user() ? $request->user()->name : null,
                    'avatar' => $request->user() ? md5($request->user()->name . $request->user()->id) : null,
                    'email' => $request->user() ? $request->user()->email : null,
                ],
            ],
            'ziggy' => function() {
                return (new Ziggy)->toArray();
            },
            'groups' => $groups,
            'wallets' => $wallets,
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
            ],
        ]);
    }
}
