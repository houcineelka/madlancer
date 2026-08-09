<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use App\Models\Gig;
use Livewire\Component;

class AllGigsComponent extends Component
{
    public $category;
    public $name;

    // filters
    public $sort_by;
    public $min_price;
    public $max_price;
    public $delivery_time;
    public $rating;

    public $delivery_times;

    protected $queryString = ['min_price', 'max_price', 'delivery_time', 'rating', 'sort_by'];


   
    public function mount(){
            // Get category
            $category       = Category::all();
            $this->name = "All Gigs";

            // Set gig
            $this->category = $category;


    }

    public function render()
    {
        return view('livewire.categories.all-gigs-component',['gigs'=>$this->gigs])->extends('layouts.myL')->section('main');
    }
    public function getGigsProperty()
    {
        // start a new query
        $query = Gig::query()->active();

        // Check price
        if ($this->min_price) {
            $query->whereBetween('price', [$this->min_price, 999999]);
        }

        // Set max price
        if ($this->max_price) {
            $query->whereBetween('price', [0, $this->max_price]);
        }

        // Check delivery time
        if ($this->delivery_time) {
            $query->where('delivery_time', $this->delivery_time);
        }

        // Check rating
        if ($this->rating) {
            $query->whereBetween('rating', [$this->rating, $this->rating +1]);
        }

         // Check sort by
         if ($this->sort_by) {
            switch ($this->sort_by) {

                // Most popular
                case 'popular':
                    $query->orderByDesc('counter_visits');
                    break;

                // Best rating
                case 'rating':
                    $query->orderByDesc('rating');
                    break;

                // Most sales
                case 'sales':
                    $query->orderByDesc('counter_sales');
                    break;

                // Newest
                case 'newest':
                    $query->orderByDesc('id');
                    break;

                // Price low to high
                case 'low':
                    $query->orderBy('price', 'desc');
                    break;

                // Price high to low
                case 'high':
                    $query->orderBy('price', 'asc');
                    break;
                
                default:
                    $query->orderByRaw('RAND()');
                    break;
            }
        }

        // Set results
        return $query->get();
      
    }

    public function resetFilter()
    {
        // Reset filter
        return redirect('category/all');
    }


}
