@section('title',$name)

@push('style')
<link href="{{asset('css/search-redesign.css')}}?v={{ filemtime(public_path('css/search-redesign.css')) }}" rel="stylesheet" />
@endpush

<span>
<section class="hr-section hr-page-section sr-page">
  <div class="auto-container">

    <div class="sr-hero">
      <ul class="sr-breadcrumb">
        <li>Home</li>
        <li>Gigs</li>
      </ul>
      <h1>Gigs Of {{ $name }}</h1>
    </div>

    <div class="sr-search-card">
      <form class="sr-search-form" method="get" action="{{url('/search')}}">
        <div class="sr-search-field">
          <span class="icon flaticon-search-1"></span>
          <input type="text" name="key" placeholder="What are you looking for?">
        </div>

        <div class="sr-search-select">
          <select name="by" class="form-select">
            <option value="">Search By</option>
            <option value="categories">Categories</option>
            <option value="services">Services</option>
          </select>
        </div>

        <div class="sr-search-submit">
          <button type="submit">Search</button>
        </div>
      </form>
    </div>

    <div class="sr-filter-card">
      <form class="sr-filter-form" method="get" action="{{url('categories/'.$category->slug.'/'.$subcategory->slug)}}">
        <div class="sr-filter-field">
          <select wire:model.defer="delivery_time" name="delivery_time">
            <option value="">Delivery Time</option>
            <option value="1" {{ request('delivery_time') == 1 ? 'selected' : '' }}>Express 24H</option>
            <option value="3" {{ request('delivery_time') == 3 ? 'selected' : '' }}>Up to 3 days</option>
            <option value="7" {{ request('delivery_time') == 7 ? 'selected' : '' }}>Up to 7 days</option>
          </select>
        </div>

        <div class="sr-filter-field">
          <select name="rating" wire:model.defer="rating">
            <option value="">Choose rating</option>
            <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1 star</option>
            <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2 star</option>
            <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3 star</option>
            <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4 star</option>
            <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 star</option>
          </select>
        </div>

        <div class="sr-filter-field">
          <select name="sort_by" onchange="this.form.submit()">
            <option value="">Sort by</option>
            <option value="popular" {{ request('sort_by') == "popular" ? 'selected' : '' }}>Most popular</option>
            <option value="rating" {{ request('sort_by') == "rating" ? 'selected' : '' }}>Best rating</option>
            <option value="sales" {{ request('sort_by') == "sales" ? 'selected' : '' }}>Most selling</option>
            <option value="newest" {{ request('sort_by') == "newest" ? 'selected' : '' }}>Newest first</option>
            <option value="low" {{ request('sort_by') == "low" ? 'selected' : '' }}>Price : Low to High</option>
            <option value="high" {{ request('sort_by') == "high" ? 'selected' : '' }}>Price : High to Low</option>
          </select>
        </div>

        <div class="sr-filter-actions">
          <button type="submit" class="sr-filter-apply">Filter</button>

          @if ($rating || $delivery_time || $min_price || $max_price)
            <button wire:click="resetFilter" class="sr-filter-reset">Reset</button>
          @endif
        </div>
      </form>
    </div>

    @if ($gigs->count() > 0)
      <div class="sr-meta">
        <strong>{{ $gigs->count() }}</strong> gig{{ $gigs->count() > 1 ? 's' : '' }} found
      </div>
    @endif

    <div class="sr-results">
      <div class="row mb-5">
        @forelse ($gigs as $g)
          <livewire:cards.gig :g='$g' />
        @empty
          <div class="col-12">
            <div class="sr-empty">
              <div class="icon flaticon-search-1"></div>
              <h3>No gigs found</h3>
              <p>There are no gigs matching your filters right now.</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>

  </div>
</section>
</span>
