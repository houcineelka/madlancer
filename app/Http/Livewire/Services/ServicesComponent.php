<?php

namespace App\Http\Livewire\Services;

use App\Jobs\Main\Service\Track;
use App\Models\Favorite;
use App\Models\Gig;
use App\Models\GigUpgrade;
use App\Models\UserAvailability;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class ServicesComponent extends Component
{
    public $slug;
    public $gig;
    public $recommended ;
    public $favorite = false;
    public $upgrades   = [];
    public $quantity   = 1;



    public function mount($slug){
        $this->slug=$slug;


        // filter gigs 
        $gig= Gig::where('slug', $slug)->firstOrFail();
        $this->gig=$gig;

        // recommended gigs
        $this->recommended = $this->recommendedGigs();

        $this->favorite = $this->Favorite();

        // Track visit
        Track::dispatch([
            'gig_id'       => $gig->id,
            'ip'           => request()->ip(),
            'ua'           => request()->userAgent(),
            'language'     => request()->header('Accept-Language'),
            'utm_medium'   => request('utm_medium'),
            'utm_campaign' => request('utm_campaign'),
            'utm_source'   => request('utm_source'),
            'queries'      => request()->getQueryString(),
            'referrer'     => request()->header('referer'),
        ]);

    }

    public function render()
    {
        
        return view('livewire.services.services-component')->extends('layouts.myL')->section('main');
    }

    private function recommendedGigs()
    {
        // recommended gigs
        $gigs = Gig::where(function($query) {
                        return $query->where('title', 'LIKE', "%{$this->gig->title}%")
                                     ->orWhere('description', 'LIKE', "%{$this->gig->title}%")
                                     ->orWhere('description', 'LIKE', "%{$this->gig->description}%")
                                     ->orWhere('description', 'LIKE', "%{$this->gig->title}%")
                                     ->orWhere('subcategory_id', $this->gig->subcategory_id);
                    })
                    ->where('id', '!=', $this->gig->id)
                    ->active()
                    ->orderByRaw('RAND()')
                    ->limit(3)
                    ->get();

        // Return related gigs
        return $gigs;
    }

    private function Favorite()
    {
        // auth
        if (auth()->guest()) {
            return false;
        }

        // test about leader of gig
        if (auth()->id() === $this->gig?->user_id) {
            return false;
        }

        // search about gig in list of favorite
        $favorite = Favorite::where('gig_id', $this->gig->id)->where('user_id', auth()->id())->first();
        
        if ($favorite) {
            return true;
        }

        return false;
    }
    

    public function addF()
    {
        try {
            
            // check auth user
            if (auth()->guest()) {
                
                $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => 'please login or register to add to favovorite']);
                return;
            }

            // search in list of favorite if exist or not
            $inF = Favorite::where('user_id', auth()->id())->where('gig_id', $this->gig->id)->first();

            // Check if already exists
            if ($inF) {
                
                $this->dispatchBrowserEvent('alert',["message" => 'this gig already in favorite list',"type"=> "info"]);
            }

            // Add to list
            Favorite::create(['gig_id'  => $this->gig->id,'user_id' => auth()->id()]);

            // change status of favorite
            $this->favorite = true;

            $this->dispatchBrowserEvent('alert',["message" => " gig has been added to favorite list","type"=> "success"]);


        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('alert',["message" => "something went wrong","type"=> "error"]);

        }
    }



    public function removeF()
    {
        try {

            // Check if already exists
            $favorite = Favorite::where('user_id', auth()->id())->where('gig_id', $this->gig->id)->first();

            if ($favorite) {
                
                $favorite->delete();

                // change status of favorite
                $this->favorite = false;

                $this->dispatchBrowserEvent('alert',[ 'type' => 'success',"message" =>"gig removed from your favorite list"]);


            }

        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('alert',["message" => "something went wrong","type"=> "error"]);

        }
    }


    public function addToCart()
    {
        try {
            
            // Get  availability
            $availability = UserAvailability::where('user_id', $this->gig->user_id)->first();

            // Check if seller available to receive orders
            if ($availability) {
                
                $this->dispatchBrowserEvent('alert',[
                    "message" =>"seller won't be able to receive orders soon",
                    "type"    => "error"
                ]);

                return;

            }

            // You can't add your own gigs
            if (auth()->check() && auth()->id() === $this->gig->user_id) {
                
                $this->dispatchBrowserEvent('alert',[
                    "message" => "you can't add your own gigs to shopping cart",
                    "type"    => "error"
                ]);

                return;

            }
            
            if (!in_array($this->quantity, range(1, 10))) {
                
                $this->dispatchBrowserEvent('alert',[
                    "message" =>"selected quantity is not correct",
                    "type"    => "error"
                ]);

                return;

            }

            // Get cart
            $cart = session('cart', []);

            // Get items ids from this cart
            $ids  = array_column($cart, 'id');

            // Check if this gig already exists in cart
            if (in_array($this->gig->uid, $ids)) {
                
                // Remove item
                foreach ($cart as $key => $value) {
                    if ($value['id'] === $this->gig->uid) {
                        // Remove item from cart
                        unset($cart[$key]);

                        // Break
                        break;
                    }
                }

                // Refresh cart
                array_merge($cart);

            }

            // Item not exist in cart, set it
            $item                     = [];

            // Set gig uid
            $item['id']               = $this->gig->uid;

            // Set quantity
            $item['quantity']         = (int) $this->quantity;

            // Set gig
            $item['gig']['title']     = $this->gig->title;
            $item['gig']['slug']      = $this->gig->slug;
            $item['gig']['price']     = $this->gig->price;
            $item['gig']['delivery']  = $this->gig->delivery_time;
            $item['gig']['thumbnail'] = src($this->gig->thumbnail);
            $item['upgrades']         = [];

            // Check if has upgrades
            if (is_array($this->upgrades) && count($this->upgrades)) {
                
                foreach ($this->upgrades as $key => $upgrade_id) {
                    
                    // Get upgrade
                    $upgrade = GigUpgrade::where('uid', $upgrade_id)->where('gig_id', $this->gig->id)->first();

                    // Check if upgrade exists
                    if ($upgrade) {
                        
                        // Add upgrade to cart
                        $item['upgrades'][$key]['id']       = $upgrade->uid;
                        $item['upgrades'][$key]['title']    = $upgrade->title;
                        $item['upgrades'][$key]['price']    = $upgrade->price;
                        $item['upgrades'][$key]['delivery'] = $upgrade->extra_days;
                        $item['upgrades'][$key]['checked']  = 1;

                    }

                }

            }

            // Add item to cart
            array_push($cart, $item);

            // Refresh cart
            array_merge($cart);

            // Update cart
            session()->put('cart', $cart);

            $this->dispatchBrowserEvent('alert',[
                "message" => "item add to cart success","type"=> "success"]);
            // Update cart
            $this->dispatchBrowserEvent('cart-updated');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    

    

}
