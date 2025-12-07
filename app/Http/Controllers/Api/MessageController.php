<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Jobs\ProcessMessageJob;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'sender_id' => 'required|integer',
            'message' => 'required|string|max:5000',
        ]);

        $message = Message::create([
            'sender_id' => $data['sender_id'],
            'message' => $data['message'],
        ]);

        // Dispatch to database queue
        ProcessMessageJob::dispatch($message->id);

        return response()->json([
            'status' => 'queued',
            'message_id' => $message->id
        ], 201);
    }
}
