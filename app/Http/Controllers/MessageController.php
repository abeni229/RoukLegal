<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Affiche la conversation entre l'utilisateur authentifié et un autre utilisateur.
     */
    /**
     * Liste sommaire des personnes avec lesquelles l'utilisateur a conversé.
     */
    public function index()
    {
        $me = Auth::user();

        if (!in_array($me->role, ['client', 'acteur_juridique', 'admin'])) {
            abort(403);
        }

        // récupérer l'id des correspondants
        $correspondents = Message::where('sender_id', $me->id)
            ->orWhere('receiver_id', $me->id)
            ->get()
            ->map(function ($m) use ($me) {
                return $m->sender_id === $me->id ? $m->receiver_id : $m->sender_id;
            })
            ->unique()
            ->values();

        $users = User::whereIn('id', $correspondents)->get();

        return view('messages.index', compact('users'));
    }

    public function conversation(User $user)
    {
        $me = Auth::user();

        // ne pas autoriser l'accès à soi-même
        if ($me->id === $user->id) {
            abort(404);
        }

        // Restreindre l'utilisation aux clients et acteurs (admin peut lire aussi)
        if (!in_array($me->role, ['client', 'acteur_juridique', 'admin'])) {
            abort(403);
        }

        // si client, vérifier qu'il a droit à la discussion (abonnement ou essai)
        if ($me->role === 'client' && !$me->canAccessResponses()) {
            return redirect()->back()->with('status', 'Vous devez être abonné pour contacter un professionnel.');
        }

        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($q) use ($me, $user) {
                $q->where('sender_id', $me->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($me, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $me->id);
            })->orderBy('created_at')->get();

        return view('messages.conversation', compact('messages', 'user'));
    }

    /**
     * Envoie un message à l'utilisateur ciblé.
     */
    public function send(Request $request, User $user)
    {
        $me = Auth::user();

        // validation similaire à conversation
        if ($me->id === $user->id) {
            abort(404);
        }

        $data = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        Message::create([
            'sender_id' => $me->id,
            'receiver_id' => $user->id,
            'message' => $data['message'],
        ]);

        return redirect()->route('messages.conversation', ['user' => $user->id]);
    }
}
