<?php

namespace App\Http\Livewire\Partials;

use App\Models\ConversationMessage;
use App\Models\Notification;
use Livewire\Component;

class Notifications extends Component
{
    public $new_messages;
    public $notifications;
    public $count;

    public function mount()
    {
        // Check if user online
        if (auth()->check()) {
            
            // Count unread messages
            $unread_message      = ConversationMessage::where('message_to', auth()->id())
                                                      ->where('is_seen', false)
                                                      ->count();

            // Set unread messages
            $this->new_messages  = $unread_message;


            // Get notifications
            $this->notifications = Notification::where('user_id', auth()->id())->where('is_seen', false)->latest()->get();

            $this->count  = count($this->notifications);

        }
    }

    
    public function render()
    {
        return view('livewire.partials.notifications');
    }

    public function readNotification($id)
    {
        // Get notification
        Notification::where('uid', $id)->where('user_id', auth()->id())->update([
            'is_seen' => true
        ]);

        // Refresh notifications
        $this->notifications = Notification::where('user_id', auth()->id())->where('is_seen', false)->latest()->get();
        $this->count  = count($this->notifications);

    }
}
