<?php

namespace App\Http\Livewire\Cards;

use App\Models\Favorite;
use App\Models\Gig as ModelsGig;
use Livewire\Component;

class Gig extends Component
{
    public $g;
    public $favorite = false;

    public function mount($g)
    {
        $this->g=$g;
        
        if (auth()->check()) {
            
            $this->favorite = Favorite::where('user_id', auth()->id())->where('gig_id', $g->id)->first() ? true : false;

        }
    }
    public function render()
    {
        return view('livewire.cards.gig');
    }

    public function remove($id)
    {
        
        
            // search  gig and select
            $gig      = ModelsGig::where('uid', $id)->where('user_id', '!=', auth()->id())->active()->firstOrFail();

            // Check if gig already in favorite
            $favorite = Favorite::where('user_id', auth()->id())->where('gig_id', $gig->id)->first();

            // Check if already exists
            if ($favorite) {
                
                $favorite->delete();

                $this->favorite = false;

                $this->dispatchBrowserEvent('alert',[ 'type' => 'success',"message" =>"gig removed from your favorite list"]);

            }

   
    }


    public function add($id)
    {
        try{
            // select  gig
            $gig        = ModelsGig::where('uid', $id)->where('user_id', '!=', auth()->id())->active()->firstOrFail();

            // Check if gig already in favorite
            $in_favorite = Favorite::where('user_id', auth()->id())->where('gig_id', $gig->id)->first();

            // Check if already exists
            if ($in_favorite) {
                
                $this->dispatchBrowserEvent('alert',["message" => 'this gig already in favorite list',"type"=> "info"]);

            }

            // Add gig to favorite
            Favorite::create(['gig_id'  => $gig->id,'user_id' => auth()->id()]);

            $this->favorite = true;

            $this->dispatchBrowserEvent('alert',["message" => " gig has been added to favorite list","type"=> "success"]);

        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('alert',["message" => "something went wrong","type"=> "error"]);


        }

    }
    public function alertError()
    {
        $this->dispatchBrowserEvent('alert',['type' => 'info',  'message' => 'please login or register to add to favovorite']);
    }

 


    // public function alertSuccess()
    // {
    //     $this->dispatchBrowserEvent('alert', 
    //             ['type' => 'success',  'message' => 'User Created Successfully!']);
    // }
  
    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    // public function alertError()
    // {
    //     $this->dispatchBrowserEvent('alert', 
    //             ['type' => 'info',  'message' => 'please login or register to add to favovorite']);
    // }
  
    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    // public function alertInfo()
    // {
    //     $this->dispatchBrowserEvent('alert', 
    //             ['type' => 'info',  'message' => 'Going Well!']);
    // }

 
}
