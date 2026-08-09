<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use App\Models\Gig;
use App\Models\Subcategory;
use Livewire\Component;

class SubcategoryComponent extends Component
{   

    public $category;
    public $subcategory;
    public $name;

    // filters
    public $sort_by;
    public $min_price;
    public $max_price;
    public $delivery_time;
    public $rating;


    protected $queryString = ['min_price', 'max_price', 'delivery_time', 'rating', 'sort_by'];
   

    public function mount($parent, $subcategory)
    {
        $category          = Category::where('slug', $parent)->firstOrFail();

        $subcategory       = Subcategory::where('slug', $subcategory)->where('parent_id', $category->id)->firstOrFail();

        $this->name=$subcategory->name ;

        $this->subcategory = $subcategory;

        $this->category    = $category;

 
    }
    public function render()
    {
        //search category
        //     $c=Category::where('uid','=',$this->cat)->get();
        // //search subcategory
        //     $s=Subcategory::where('uid','=',$this->subcategory)->get();
        //     $this->name=$s[0]->name;
        // //search in gigs with sub and cat
        //     $this->gigs=Gig::where('category_id','=',$c[0]->id)->where('subcategory_id','=',$s[0]->id)->paginate(2);
        //return result to view 
        return view('livewire.categories.subcategory-component',['gigs'=>$this->gigs])->extends('layouts.myL')->section('main');
    }

    public function getGigsProperty()
    {
        // start a new query
        $query = Gig::query()->where('subcategory_id', $this->subcategory->id)->active();

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
        return redirect('categories/' . $this->category->slug . "/" . $this->subcategory->slug);
    }

}
