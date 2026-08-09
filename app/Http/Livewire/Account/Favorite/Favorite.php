<?php

namespace App\Http\Livewire\Account\Favorite;

use App\Models\Favorite as ModelsFavorite;
use Livewire\Component;
use Livewire\WithPagination;

class Favorite extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.account.favorite.favorite', [
            'list' => $this->list
        ])->extends('layouts.myL')->section('main');
    }
    public function getListProperty()
    {
        return ModelsFavorite::where('user_id', auth()->id())->latest()->paginate(42);
    }


    /**
     * Delete from favorite list
     *
     * @param integer $id
     * @return void
     */
    public function delete($id)
    {
        // Delete from list
        ModelsFavorite::where('id', $id)->where('user_id', auth()->id())->delete();

        // Success
        // success
        $this->dispatchBrowserEvent('alert',[
            "message" => __('messages.t_gig_removed_from_ur_favorite_list'),
            "type"    => "success"
        ]);
    }
}
