<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use App\Models\Gig;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Livewire\Component;

class GigsComponent extends Component

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


   
    public function mount($parent){
            // Get category
            $category       = Category::where('slug', $parent)->firstOrFail();
            $this->name = $category->name;

            // Set gig
            $this->category = $category;


    }

   
    public function render()
    {

        // $this->categories=Category::all();

        // //test category if all or with one category
        // if($this->cat=="all"){
        //     $this->gigs=Gig::paginate(2);
        //     $this->name="All Gigs";
         
        // }else{
        //     //search category
        //     $c=Category::where('uid','=',$this->cat)->get();
        //     $this->name=$c[0]->name;
        //     //search with category in gigs
        //     $this->gigs=Gig::where('category_id','=',$c[0]->id)->paginate(2);
        // }


        
        //return result to view 
        return view('livewire.categories.gigs-component',['gigs'=>$this->gigs])->extends('layouts.myL')->section('main');

    }


    public function getGigsProperty()
    {
        // start a new query
        $query = Gig::query()->where('category_id', $this->category->id)->active();

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
                    $query->inRandomOrder();
                    break;
            }
        }

        // Set results
        return $query->get();
      
    }

    public function resetFilter()
    {
        // Reset filter
        return redirect('categories/' . $this->category->slug);
    }


  

 
}
