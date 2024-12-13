<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationsController extends Controller
{

    public $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $user = Auth::user();
        $user = User::find($user->id);
        $notifications = $user->notifications()->paginate(10);
        if ($notifications->count() > 0) {
            foreach ($notifications as $row) {
                $date = date('j M Y', strtotime($row->created_at));
                $time = date('h:i:s a', strtotime($row->created_at));

                $row->social_time = $row->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true);
            }
        }

        $props['notis'] = $notifications;
        $props['auth_user'] = $user;
        // return $props;
        return Inertia::render('Notification/Index', $props);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DatabaseNotification $notification)
    {
        $user = Auth::user();
        if ($notification->notifiable_id == $user->id) {
            $notification->markAsRead();

            $notification->date = date('j M Y', strtotime($notification->created_at));
            $notification->time = date('h:i:s a', strtotime($notification->created_at));

            $notification->read_at_str = date('j M Y h:i:s a', strtotime($notification->read_at));
            // return $notification;
            $props['notification'] = $notification;

            $props['auth_user'] = $user;
            return Inertia::render('Notification/Show', $props);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
