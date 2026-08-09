@section('title','Home')

<span>
<div class="page-template-content page-home-page-1">
    <section class="hr-hero">
      <div class="hr-hero__shapes">
        <div class="hr-shape hr-shape--dots"></div>
        <div class="hr-shape hr-shape--circle-outline"></div>
        <div class="hr-shape hr-shape--circle-fill"></div>
        <div class="hr-shape hr-shape--square"></div>
        <div class="hr-shape hr-shape--diamond"></div>
        <div class="hr-shape hr-shape--rings"></div>
        <div class="hr-shape hr-shape--dots-right"></div>
      </div>
      <div class="auto-container">
        <div class="hr-hero__inner">
          <span class="hr-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
            Your Talent. Limitless Opportunities.
          </span>

          <h1>
            There Are More Than <span class="hr-accent">10,000</span> Services And Jobs Here For you!
          </h1>
          <p class="hr-hero__subtitle">
            Find the perfect freelance services or a dream job that matches your skills.
          </p>

          <form method="get" action="{{ url('/search') }}">
            <div class="hr-searchbar">
              <div class="hr-searchbar__field">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="key" placeholder="What are you looking for?" />
              </div>
              <div class="hr-searchbar__divider"></div>
              <div class="hr-searchbar__field" style="flex:0 0 250px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                <select name="by" class="form-select">
                  <option value="">Search By Category</option>
                  <option value="categories">Category</option>
                  <option value="services">Services</option>
                </select>
              </div>
              <button type="submit" class="hr-searchbar__submit">Search</button>
            </div>
          </form>

          <div class="hr-popular">
            <span class="hr-popular__label">Popular Searches:</span>
            <a href="{{ url('/search?key=Designer') }}">Designer</a>
            <a href="{{ url('/search?key=Developer') }}">Developer</a>
            <a href="{{ url('/search?key=Web') }}">Web</a>
            <a href="{{ url('/search?key=WordPress') }}">WordPress</a>
            <a href="{{ url('/search?key=SEO') }}">SEO</a>
          </div>
        </div>
      </div>
    </section>

    <section class="hr-section hr-how" id="how-it-works">
      <div class="auto-container">
        <div class="hr-how__head">
          <h2>How It Works</h2>
          <p class="hr-how__subtitle">Get your project done in three simple steps.</p>
        </div>
        <div class="hr-steps">
          <div class="hr-step">
            <span class="hr-step__number">01</span>
            <div class="hr-step__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <h3>Search & Discover</h3>
            <p>Browse thousands of services from skilled freelancers across every category.</p>
          </div>
          <div class="hr-step">
            <span class="hr-step__number">02</span>
            <div class="hr-step__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            </div>
            <h3>Chat & Order</h3>
            <p>Message the seller, agree on the details, and place your order securely.</p>
          </div>
          <div class="hr-step">
            <span class="hr-step__number">03</span>
            <div class="hr-step__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
            <h3>Get It Delivered</h3>
            <p>Receive your completed work on time and release payment once you're satisfied.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="hr-section">
      <div class="auto-container">
        <div class="hr-section__head">
          <h2>Latest Gigs</h2>
          <a href="{{ url('category/all') }}" class="hr-section__link">
            View All Gigs
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
        <div class="hr-gig-grid wow fadeInUp">

            @foreach ($lat as $g)

            <div class="hr-gig-grid__item">
              <div class="hr-gig-card">
                <div class="hr-gig-card__media">
                  <a href="{{ url('service', $g->slug) }}">
                    <img class="lazy loaded" src="{{src($g->thumbnail)}}" alt="{{ $g->title }}" data-was-processed="true">
                  </a>
                  <button type="button" class="hr-gig-card__fav service-wishlist" data-id="{{ $g->id }}" data-type="gig" aria-label="Add to favorites">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                  </button>
                </div>
                <div class="hr-gig-card__body">
                  <h3 class="hr-gig-card__title">
                    <a href="{{ url('service', $g->slug) }}" class="text-reset">{{ $g->title }}</a>
                  </h3>
                  <div class="hr-gig-card__author">
                    <img src="{{src($g->owner->avatar)}}" alt="{{ $g->owner->username }}">
                    <span>{{ $g->owner->username }}</span>
                    @if($g->owner->status === 'active')
                      <span class="hr-gig-card__verified" title="Verified seller">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 1.4 2.8-.3 1.3 2.5 2.5 1.3-.3 2.8L22 12l-1.4 2.4.3 2.8-2.5 1.3-1.3 2.5-2.8-.3L12 22l-2.4-1.4-2.8.3-1.3-2.5-2.5-1.3.3-2.8L2 12l1.4-2.4-.3-2.8 2.5-1.3 1.3-2.5 2.8.3L12 2z"/><path d="M9 12l2 2 4-4" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </span>
                    @endif
                  </div>
                  <div class="hr-gig-card__footer">
                    <div class="hr-gig-card__rating">
                      @if($g->rating == 0)
                        <span>N/A</span>
                      @else
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
                        <strong>{{ $g->rating }}</strong> ({{ number_format($g->counter_reviews) }})
                      @endif
                    </div>
                    <div class="hr-gig-card__price">${{ $g->price }}</div>
                  </div>
                </div>
              </div>
            </div>

            @endforeach

        </div>
      </div>
    </section>


    <livewire:news-component />
    
  </div>


</span>
