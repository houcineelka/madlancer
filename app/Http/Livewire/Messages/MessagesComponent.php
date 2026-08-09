<?php

namespace App\Http\Livewire\Messages;

use App\Models\Conversation;
use Livewire\Component;

class MessagesComponent extends Component
{
    public $currentConv;
    public function mount(){
        $this->currentConv = Conversation::where('uid', request('conversationId'))->first();
    }
    public function render()
    {
        return view('livewire.messages.messages-component',[
            'conversations' => $this->conversations 
        ])->extends('layouts.myL')->section('main');
    }

    public function getConversationsProperty()
    {
        return Conversation::where(function($query) {
                                return $query->where('from_id', auth()->id())->orWhere('to_id', auth()->id());
                            })->latest('last_message_at')->get();
    }
    public function block()
    {
        // Get conversation
        // We have to load conversation to prevent user from block another one
        $conversation             = Conversation::where('uid', $this->currentConv->uid)->where(function($query) {
                                                    return $query->where('from_id', auth()->id())->orWhere('to_id', auth()->id());
                                                })->where('status', 'active')->firstOrFail();
        
        // Block conversation
        $conversation->status     = 'blocked';
        $conversation->blocked_by = auth()->id();
        $conversation->save();

        // Update conversation
        $this->currentConv = $conversation;
        // Success
        $this->dispatchBrowserEvent('alert',[
            "message" => __('messages.t_conversation_blocked_successfully')
        ]);
        $this->emit(event : 'refreshConv');
    }

    public function unblock()
    {
        // Get conversation
        // Only the user who blocked it can unblock it
        $conversation             = Conversation::where('uid', $this->currentConv->uid)->where(function($query) {
                                                    return $query->where('from_id', auth()->id())->orWhere('to_id', auth()->id());
                                                })->where('status', 'blocked')->where('blocked_by', auth()->id())->firstOrFail();

        // Unblock conversation
        $conversation->status     = 'active';
        $conversation->blocked_by = null;
        $conversation->save();

        // Update conversation
        $this->currentConv = $conversation;
        // Success
        $this->dispatchBrowserEvent('alert',[
            "message" => __('messages.t_conversation_unblocked_successfully')
        ]);
        $this->emit(event : 'refreshConv');
    }

}
