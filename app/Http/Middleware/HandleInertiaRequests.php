<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Illuminate\Http\Request;
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
            ]),
        ]);

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
        ]);
    }
}
