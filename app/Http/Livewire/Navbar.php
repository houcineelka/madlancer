<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\ConversationMessage;
use App\Models\Notification;
use App\Models\Subcategory;
use Livewire\Component;

class Navbar extends Component
{
    public $categories;
    public $subs;
    public $show=false;
    public $show02=false;
    
    public $new_messages;
    public $notifications;
    
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

        }
    }


    public function showL(){
         $this->show= !$this->show;
    }
    public function showR(){
        $this->show02= !$this->show02;
   }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getSubsProperty()
    {
        return Subcategory::all();
    }

    public function render()
    {
        $this->categories = $this-> getCategoriesProperty();
        $this->subs = $this-> getSubsProperty();
        return view('livewire.navbar');
    }
}
