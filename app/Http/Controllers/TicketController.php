<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Http\Requests\StoreTicket;


class TicketController extends Controller
{
    public function index()
    {
        return Ticket::with('replies.user') -> where('user_id', auth()->id()) -> get();
    }

    public function store(StoreTicket $request)
    {
        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'tittle' => $request->tittle,
            'description' => $request->description
        ]);

    return response()->json($ticket, 201);
    }

    public function show(Ticket $ticket)
    {
        if($ticket->user_id !== auth()->id())
        {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $ticket->load('replies.user');
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $ticket->update($request->only('status'));
        return response()->json($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return response()->json(['message' => 'Ticket berhasil dihapus']);
    }
}
