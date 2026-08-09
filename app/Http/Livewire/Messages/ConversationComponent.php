<?php

namespace App\Http\Livewire\Messages;

use App\Http\Validators\Main\Messages\SendValidator;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Notifications\User\Everyone\NewMessage;
use Cache;
use Livewire\Component;

class ConversationComponent extends Component
{
    
    public $conversation;
    public $message;
    public $page = 1;

    protected $listeners = [
        'load-more' => 'loadMore',
        'load-previous' => 'loadPrevious',
        'refreshConv' => '$refresh',
    ];
   
    
    public function loadMore()
    {
        $this->page++;
    }

    public function loadPrevious()
    {
        $this->page--;
    }

    public function mount($conversationId)
    {
        // Get conversation
        $conversation = Conversation::where('uid', $conversationId)->first();

        // Check if conversation exists
        if (!$conversation) {
            return abort(404);
        }

        // Check if user has permissions to see this conversation
        if ($conversation->from_id === auth()->id() || $conversation->to_id === auth()->id()) {
            
            // Set conversation
            $this->conversation = $conversation;

        } else {

            // User has no permission
            return redirect('messages');

        }

        // Mark messages as read
        $this->markAsRead();

    }


    public function render()
    {  
        return view('livewire.messages.conversation-component', [
            'messages'      => $this->messages
        ]);
    }


    public function getMessagesProperty()
    {
        return ConversationMessage::where('conversation_id', $this->conversation->id)->latest('created_at')->paginate(20, ['*'], 'page', $this->page);
    }



    public function send()
    {
        try {

            // Validate form
            SendValidator::validate($this);

            // Get conversation
            $conversation = Conversation::where('uid', $this->conversation->uid)
                                        ->where(function($query) {
                                            return $query->where('from_id', auth()->id())->orWhere('to_id', auth()->id());
                                        })
                                        ->first();

            // Check if conversation exists
            if (!$conversation) {
                
                // Conversation not exists
                $this->dispatchBrowserEvent('alert',[
                    "message" => __('messages.t_conversation_not_exists'),
                    "type"    => "error"
                ]);

                return;

            }

            // Check if conversation blocked
            if ($conversation->status === 'blocked') {
                
                // Conversation not exists
                $this->dispatchBrowserEvent('alert',[
                    "message" => __('messages.t_u_cant_reply_this_conversation'),
                    "type"    => "error"
                ]);

                return;

            }

            // Save message
            $message                       = new ConversationMessage();
            $message->uid                  = uid();
            $message->conversation_id      = $this->conversation->id;
            $message->message_from         = auth()->id();
            $message->message_to           = $conversation->from_id === auth()->id() ? $conversation->to_id : $conversation->from_id;
            $message->message              = clean($this->message);
            $message->save();

            // Update last message
            $conversation->last_message_at = now();
            $conversation->save();

            // Refresh conversation
            $this->conversation            = $conversation;

            // Check if user who will receive this message is offline
            if (!$conversation->sender->isOnline()) {

                // Set cache key
                $cache_key = "messages-notification-email-conversation-" . $conversation->uid;
                
                // User right now is offline
                // We have to get last message
                // Because we can't send notification on every new message
                // So we will make sure that at least 1 hour past since last message
                if (!Cache::has($cache_key)) {
                    
                    // Send a notification to him via email
                    $conversation->sender->notify( (new NewMessage($conversation, $message))->locale(config('app.locale')) );

                    // Send notification
                    notification([
                        'text'    => 't_u_have_new_message_from_username',
                        'action'  => url('messages', $conversation->uid),
                        'user_id' => $conversation->sender->id,
                        'params'  => ['username' => auth()->user()->username]
                    ]);

                    // Set cache key, to prevent multiple notification at short time
                    Cache::set($cache_key, true, now()->addHour());
                    
                }
                

            }

            // Reset form
            $this->reset('message');
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_form_validation_error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_something_went_wrong'),
                "type"    => "error"
            ]);

            throw $th;

        }
    }


    public function markAsRead()
    {
        // Mark all messages as read
        ConversationMessage::where('conversation_id', $this->conversation->id)
                            ->where('message_from', '!=', auth()->id())
                            ->update([
                                'is_seen' => true
                            ]);
    }
    
}
