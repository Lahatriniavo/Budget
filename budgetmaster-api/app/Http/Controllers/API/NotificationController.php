<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'type' => $request->type,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json($notification, 201);
    }
}

