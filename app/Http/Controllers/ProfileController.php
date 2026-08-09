<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('isActive')->only('profile');
    }
    public function index()
    {
        $data['user'] = Auth::user();
        $data['last_delivery'] = $this->getLastDelivery($data['user']->id);
        $data['gigs'] = $this->getGigs($data['user']->id);
        return view("profile.profile",$data);
    }

    
    public function profile()
    {
        $data['user'] = User::where('username',request('username'))->first();
        $data['last_delivery'] = $this->getLastDelivery($data['user']->id);
        $data['gigs'] = $this->getGigs($data['user']->id);
        return view("profile.profile",$data);
    }

    
    /**
     * Get last delivered item
     *
     * @return mixed
     */
    public function getLastDelivery($id)
    {
        // Get last delivery item
        $item = OrderItem::where('owner_id', $id)->where('status', 'delivered')->latest()->first();

        // Check if user has item
        if ($item) {
            return $item->delivered_at;
        }

        // No item found
        return null;
    }

     /**
     * Get user gigs
     *
     * @return object
     */
    public function getGigs($id)
    {
        return Gig::where('user_id',$id)
                  ->active()
                  ->orderByRaw('RAND()')
                  ->paginate(12);
    }

}
