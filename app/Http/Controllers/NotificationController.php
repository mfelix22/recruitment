<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** List all notifications for the logged-in user */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /** Mark a single notification as read, then go to its target URL */
    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $url = $notification->data['url'] ?? null;

        return $url ? redirect($url) : back();
    }

    /** Mark all notifications as read */
    public function markAllRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}
