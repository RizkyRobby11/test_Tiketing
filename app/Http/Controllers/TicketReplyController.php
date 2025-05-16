<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketReplyController extends Controller
{
    public function store (Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        if($ticket->user_id !== auth()->id())
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $reply = $ticket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return response()->json($reply, 201);
    }
}
