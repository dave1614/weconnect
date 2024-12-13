<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Inertia\Middleware;

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
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => !is_null($request->user()) ? User::find($request->user()->id) : null,
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                    'data' => $request->session()->get('data'),
                ];
            },
            'notifications_num' => function () use ($request) {
                return $request->user() ? $request->user()->notifications()->get()->count()  : null;
            },
            'notifications' => function () use ($request) {


                if($request->user()){
                    $notifications = $request->user()->notifications()->limit(25)->get();
                    if ($notifications->count() > 0) {
                        foreach ($notifications as $row) {
                            $date = date('j M Y', strtotime($row->created_at));
                            $time = date('h:i:s a', strtotime($row->created_at));

                            $row->social_time = $row->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true);
                        }
                    }
                    return $notifications;
                }else{
                    return null;
                }
            },
        ];
    }
}
