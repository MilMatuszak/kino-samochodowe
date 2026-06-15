<?php

namespace App\Http\Controllers;

use App\Models\NotificationLog;

class NotificationController extends Controller
{
    public function index()
    {
        $powiadomienia = NotificationLog::with('user')->latest()->paginate(25);
        return view('admin.notifications.index', compact('powiadomienia'));
    }
}
