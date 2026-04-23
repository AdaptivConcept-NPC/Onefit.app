<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Friend;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;

class CommunityController extends Controller
{
    /**
     * Get all friends of the current user.
     */
    public function getFriends(Request $request)
    {
        $user = $request->user();
        $friends = Friend::where('users_username', $user->username)
            ->where('friend_status', 'accepted')
            ->with('friendUser')
            ->get();
            
        return response()->json($friends);
    }

    /**
     * Get all conversations.
     */
    public function getConversations(Request $request)
    {
        $user = $request->user();
        $conversations = Conversation::where('primary_user', $user->username)
            ->orWhere('secondary_user', $user->username)
            ->with(['messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get();
            
        return response()->json($conversations);
    }

    /**
     * Get messages for a specific conversation.
     */
    public function getMessages(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);
        
        // Basic security check
        if ($conversation->primary_user !== $request->user()->username && 
            $conversation->secondary_user !== $request->user()->username) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($conversation->messages()->oldest()->get());
    }

    /**
     * Get notifications.
     */
    public function getNotifications(Request $request)
    {
        $notifications = Notification::where('notify_user', $request->user()->username)
            ->latest()
            ->get();
            
        return response()->json($notifications);
    }
}
