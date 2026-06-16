<?php
namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class ChatController extends Controller {

    public function index() {
        $user     = auth()->user();
        $contacts = $this->getContacts($user);

        $contacts = $contacts->map(function($contact) use ($user) {
            $contact->unread = Chat::where('sender_id', $contact->id)
                ->where('receiver_id', $user->id)
                ->where('dibaca', false)->count();
            return $contact;
        });

        $activeContact = null;
        $chats         = collect();

        if (request('with')) {
            $activeContact = User::findOrFail(request('with'));

            Chat::where('sender_id', $activeContact->id)
                ->where('receiver_id', $user->id)
                ->where('dibaca', false)
                ->update(['dibaca' => true]);

            $chats = Chat::where(function($q) use ($user, $activeContact) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $activeContact->id);
                })->orWhere(function($q) use ($user, $activeContact) {
                    $q->where('sender_id', $activeContact->id)
                      ->where('receiver_id', $user->id);
                })->orderBy('created_at')->get();
        }

        return view('chat.index', compact('contacts', 'activeContact', 'chats'));
    }

    public function send(Request $request) {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'pesan'       => 'required|string|max:1000',
        ]);

        Chat::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'pesan'       => $request->pesan,
        ]);

        $role = auth()->user()->role;
        return redirect()->route($role . '.chat.index', ['with' => $request->receiver_id]);
    }

    private function getContacts($user) {
        if ($user->isAdmin()) {
            return User::whereIn('role', ['customer', 'mua'])
                ->where('is_active', true)->get();

        } elseif ($user->isMua()) {
            $admin = User::where('role', 'admin')->first();
            $customerIds = Booking::where('mua_id', $user->mua->id)
                ->pluck('customer_id')->unique();
            $customers = User::whereIn('id', $customerIds)->get();
            return collect([$admin])->merge($customers)->filter()->values();

        } else {
            $admin  = User::where('role', 'admin')->first();
            $muaIds = Booking::where('customer_id', $user->id)
                ->pluck('mua_id')->unique();
            $muaUsers = User::whereHas('mua', function($q) use ($muaIds) {
                $q->whereIn('id', $muaIds);
            })->get();
            return collect([$admin])->merge($muaUsers)->filter()->values();
        }
    }
}
