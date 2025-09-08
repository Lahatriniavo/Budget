<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return Notification::where('user_id', $request->user()->id)
                           ->orderBy('created_at', 'desc')
                           ->get();
    }

    public function markAsRead(Request $request, $id)
    {
        $notif = Notification::where('user_id', $request->user()->id)
                             ->where('id', $id)
                             ->firstOrFail();

        $notif->is_read = true;
        $notif->save();

        return response()->json(['message' => 'Notification marquée comme lue.']);
    }
}

