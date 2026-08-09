<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use App\Models\Gig;
use App\Utils\Paginate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class SearchComponent extends Component
{
    public $by;
    public $key;
    public $name="search";
    protected $gigs=[];

    // filters
    public $rating;
    public $delivery_time;
    public $sort_by;


    public function mount(){
        $this->by=request('by');
        $this->key=request('key');
        $this->rating=request('rating');
        $this->delivery_time=request('delivery_time');
        $this->sort_by=request('sort_by');

    }

    public function resetFilter()
    {
        $query = collect(request()->query())->except(['rating', 'delivery_time', 'sort_by'])->all();
        return redirect(url('/search') . (count($query) ? '?' . http_build_query($query) : ''));
    }

    private function applyFiltersToQuery($query)
    {
        if ($this->delivery_time) {
            $query->where('delivery_time', $this->delivery_time);
        }
        if ($this->rating) {
            $query->whereBetween('rating', [$this->rating, $this->rating + 1]);
        }
        return $query;
    }

    private function applySortToQuery($query)
    {
        switch ($this->sort_by) {
            case 'popular':
                $query->orderByDesc('counter_visits');
                break;
            case 'rating':
                $query->orderByDesc('rating');
                break;
            case 'sales':
                $query->orderByDesc('counter_sales');
                break;
            case 'newest':
                $query->orderByDesc('id');
                break;
            case 'low':
                $query->orderBy('price', 'desc');
                break;
            case 'high':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->inRandomOrder();
                break;
        }
        return $query;
    }

    private function applyFiltersToCollection($collection)
    {
        return $collection
            ->when($this->delivery_time, fn($c) => $c->where('delivery_time', $this->delivery_time))
            ->when($this->rating, fn($c) => $c->whereBetween('rating', [$this->rating, $this->rating + 1]));
    }

    private function applySortToCollection($collection)
    {
        switch ($this->sort_by) {
            case 'popular':
                return $collection->sortByDesc('counter_visits')->values();
            case 'rating':
                return $collection->sortByDesc('rating')->values();
            case 'sales':
                return $collection->sortByDesc('counter_sales')->values();
            case 'newest':
                return $collection->sortByDesc('id')->values();
            case 'low':
                return $collection->sortByDesc('price')->values();
            case 'high':
                return $collection->sortBy('price')->values();
            default:
                return $collection->shuffle();
        }
    }

    public function render()
    {
        $page = request('page') ?? 1;
        $perPage = 3;

        if($this->key){
            $keyword=$this->key;
             // filter  with service
            if($this->by=="services" || $this->by==""){
                $query = Gig::query()->active()->where(function($query) use($keyword) {
                    return $query->where('title', 'LIKE', "%{$keyword}%")->orWhere('slug', 'LIKE', "%{$keyword}%")
                                ->orWhere('description', 'LIKE', "%{$keyword}%");
                });

                $query = $this->applyFiltersToQuery($query);

                if ($this->sort_by) {
                    $query = $this->applySortToQuery($query);
                } else {
                    $query->orderBy("rating","desc")->orderBy("counter_reviews","desc");
                }

                $data = $query->get();

                // Paginate the data
                $paginatedData = new LengthAwarePaginator(
                     $data->forPage($page, $perPage),
                    $data->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
                $this->gigs    = $paginatedData;

            }

            // filter  with categories

            if($this->by=="categories"){
                $cat=Category::where('name','like',"%".$this->key."%")->get();
                foreach($cat as $c){
                    foreach($c->gigs as $gs){
                        $this->gigs[]=$gs;
                    }
                }
                $data = Collection::make($this->gigs);
                $data = $this->applyFiltersToCollection($data);
                $data = $this->sort_by ? $this->applySortToCollection($data) : $data->sortByDesc('rating')->values();

                // Paginate the data
                $paginatedData = new LengthAwarePaginator(
                    $data->forPage($page, $perPage),
                    $data->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );

                $this->gigs =$paginatedData;
            }

        }else{
            // select all
            $query = $this->applyFiltersToQuery(Gig::query());
            if ($this->sort_by) {
                $this->applySortToQuery($query);
            } else {
                $query->orderBy('rating', 'DESC')->orderBy('counter_reviews', 'DESC');
            }
            $this->gigs=$query->paginate($perPage);
        }
        if($this->key=="" && $this->by==""  ){
            //  select all
            $query = $this->applyFiltersToQuery(Gig::query());
            if ($this->sort_by) {
                $this->applySortToQuery($query);
            } else {
                $query->orderBy('rating', 'DESC')->orderBy('counter_reviews', 'DESC');
            }
            $this->gigs=$query->paginate($perPage);
        }
        return view('livewire.categories.search-component',['gigs'=>$this->gigs])->extends('layouts.myL')->section('main');
    }



}
