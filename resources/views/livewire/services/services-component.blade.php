@section('title',$slug)

<span>

  <section class="hr-section hr-page-section">
    <div class="auto-container">

      @if ($gig->owner->availability)
        <div class="hr-alert">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          This seller won't be able to receive orders until {!! format_date($gig->owner->availability->expected_available_date, 'F j, Y') !!}
        </div>
      @endif

      @if ($gig->status === 'pending')
        <div class="hr-alert">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          This gig is under review and will be publicly visible soon.
        </div>
      @endif

      <div class="hr-gig-detail-grid">
        <div class="hr-gig-detail-main">

          {{-- Header --}}
          <div class="hr-gig-header">
            <h1>{{ $gig->title }}</h1>
            <div class="hr-gig-header__meta">
              <span>{{ $gig->category->name }}</span>
              <span class="sep">/</span>
              <span>{{ $gig->subcategory->name }}</span>
            </div>
            <div class="hr-gig-header__stats">
              <div class="hr-gig-header__stars">
                @if($gig->rating == 0)
                  <span style="color:var(--hr-body);">N/A</span>
                @else
                  @for ($i = 0; $i < 5; $i++)
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="{{ $i+1 <= $gig->rating ? 'currentColor' : '#DCE0E8' }}"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
                  @endfor
                  <strong>{{ $gig->rating }}</strong>
                @endif
              </div>
              <span>{{ $gig->counter_reviews }} Reviews</span>
              <span>{{ $gig->orders_in_queue }} orders in queue</span>

              @auth
                @if (auth()->id() !== $gig->user_id)
                  <button type="button" class="hr-fav-btn {{ $favorite ? 'is-active' : '' }} hr-gig-header__fav" wire:click="{{ $favorite ? 'removeF' : 'addF' }}" wire:target="{{ $favorite ? 'removeF' : 'addF' }}" aria-label="Add to favorites">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="{{ $favorite ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                  </button>
                @endif
              @endauth
            </div>
          </div>

          {{-- Gallery --}}
          <div class="hr-detail-card">
            <livewire:services.gallery-component :gig='$gig' />
          </div>

          {{-- Description --}}
          <div class="hr-detail-card">
            <h2>About This Gig</h2>
            <div class="hr-gig-description">{!! $gig->description !!}</div>
            @if($gig->tags->count())
              <div class="hr-tags">
                @foreach ($gig->tags as $tag)
                  <a href="{{ url('search?key='. $tag->slug .'&by=categories') }}" class="hr-tag">{{ $tag->name }}</a>
                @endforeach
              </div>
            @endif
          </div>

          {{-- Seller --}}
          <div class="hr-detail-card">
            <div class="hr-seller-card">
              <img class="hr-seller-card__avatar" src="{{src($gig->owner->avatar)}}" alt="{{ $gig->owner->fullname }}">
              <div class="hr-seller-card__body">
                <a href="{{ url('profile', $gig->owner->username) }}" class="hr-seller-card__name">{{ $gig->owner->fullname }}</a>
                <p class="hr-seller-card__headline">{{ $gig->owner->headline }}</p>
                <div class="hr-seller-card__stats">
                  <div>From <strong>{{ $gig->owner->country->name }}</strong></div>
                  <div>Member since <strong>{{ $gig->owner->created_at->format('M Y') }}</strong></div>
                </div>
                <div class="hr-seller-card__desc">
                  <strong>Description</strong>
                  {{ $gig->owner->description }}
                </div>
              </div>
            </div>
          </div>

          {{-- Video --}}
          <livewire:services.video-component :gig='$gig' />

          {{-- Share --}}
          <div class="hr-detail-card">
            <h3>Share this Gig</h3>
            <div class="hr-share-row">
              <a href="https://www.facebook.com/share.php?u={{ url('service', $gig->slug) }}&t={{ $gig->title }}" target="_blank" class="hr-share-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
                Facebook
              </a>
              <a href="https://twitter.com/intent/tweet?text={{ $gig->title }}%20-%20{{ url('service', $gig->slug) }}%20" target="_blank" class="hr-share-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.7.3-1.5.5-2.4.6.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.8A11.7 11.7 0 0 1 3.2 4.6a4.2 4.2 0 0 0 1.3 5.5c-.6 0-1.3-.2-1.8-.5v.1c0 2 1.4 3.6 3.3 4a4 4 0 0 1-1.9.1 4.1 4.1 0 0 0 3.9 2.9A8.3 8.3 0 0 1 2 18.6a11.6 11.6 0 0 0 6.3 1.9c7.5 0 11.7-6.4 11.7-11.9v-.5c.8-.6 1.5-1.3 2-2.2z"/></svg>
                Twitter
              </a>
              <a href="https://api.whatsapp.com/send/?text={{ $gig->title }}%20-%20{{ url('service', $gig->slug) }}%20" target="_blank" class="hr-share-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-1-.2-.1-.4-.1-.6.1-.2.3-.7 1-.9 1.2-.1.2-.3.2-.6.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.1-.3 0-.4.1-.6l.4-.5c.1-.1.2-.3.2-.4.1-.2 0-.3 0-.5-.1-.1-.6-1.5-.9-2-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.3.3-1 1-1 2.4s1 2.8 1.2 3c.1.2 2 3 4.8 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.5-.1 1.7-.7 2-1.4.2-.6.2-1.2.2-1.3-.1-.1-.3-.2-.5-.3zM12 2a10 10 0 0 0-8.5 15.2L2 22l4.9-1.3A10 10 0 1 0 12 2z"/></svg>
                WhatsApp
              </a>
              <button type="button" class="hr-share-btn" id="copyButton">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.5.4l2-2a5 5 0 0 0-7-7l-1.1 1.1"/><path d="M14 11a5 5 0 0 0-7.5-.4l-2 2a5 5 0 0 0 7 7l1.1-1.1"/></svg>
                Copy link
              </button>
            </div>
          </div>

          {{-- Report --}}
          @auth
            @if (auth()->id() !== $gig->user_id)
              <div class="hr-detail-card" x-data="{ report: false }" x-on:closemodal.window="report = false">
                <h3>Report this Gig</h3>
                <button type="button" class="hr-share-btn hr-share-btn--danger" @click="report = !report">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                  Report
                </button>
                <span x-show="report" x-cloak>
                  <livewire:report-component :gig='$gig' />
                </span>
              </div>
            @endif
          @endauth

          {{-- Recommended --}}
          @if($recommended->count())
          <div class="hr-section-block">
            <h2>Recommended For You</h2>
            <div class="hr-gig-grid hr-gig-grid--narrow">
              @foreach ($recommended as $g)
                <div class="hr-gig-card">
                  <div class="hr-gig-card__media">
                    <a href="{{ url('service', $g->slug) }}">
                      <img class="lazy loaded" src="{{src($g->thumbnail)}}" alt="{{ $g->title }}" data-was-processed="true">
                    </a>
                  </div>
                  <div class="hr-gig-card__body">
                    <h3 class="hr-gig-card__title">
                      <a href="{{ url('service', $g->slug) }}" class="text-reset">{{ $g->title }}</a>
                    </h3>
                    <div class="hr-gig-card__author">
                      <img src="{{src($g->owner->avatar)}}" alt="{{ $g->owner->username }}">
                      <span>{{ $g->owner->username }}</span>
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
              @endforeach
            </div>
          </div>
          @endif

          {{-- FAQ --}}
          @if($gig->faqs->count())
            <div class="hr-section-block">
              <h2>FAQs</h2>
              <div class="hr-faq-list">
                @foreach ($gig->faqs as $faq)
                  <div class="hr-faq-item" x-data="{ open: false }">
                    <div class="hr-faq-item__q" @click="open = !open">
                      {{ $faq->question }}
                      <svg class="hr-faq-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :style="open ? 'transform:rotate(180deg)' : ''"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="hr-faq-item__a" x-show="open" x-cloak>{{ $faq->answer }}</div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Comments --}}
          <div class="hr-section-block">
            <h2>Comments</h2>
            @if ($gig->counter_reviews)
              <div class="hr-comment-list">
                @foreach ($gig->reviews()->orderByRaw('RAND()')->take(10)->get() as $review)
                  <div class="hr-comment">
                    <img class="hr-comment__avatar" src="{{ src($review->user->avatar) }}" alt="{{ $review->user->username }}">
                    <div>
                      <span>
                        <a class="hr-comment__name" href="{{ url('profile', $review->user->username) }}" target="_blank">{{ $review->user->username }}</a>
                        <span class="hr-comment__date">{{ format_date($review->created_at, 'ago') }}</span>
                      </span>
                      @if ($review->message)
                        <p class="hr-comment__text">{{ $review->message }}</p>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <p class="hr-empty-note">No comments to show yet.</p>
            @endif
          </div>
        </div>

        <div class="hr-gig-detail-sidebar">
          <div class="hr-cart-summary">
            <div class="hr-gig-price-row">
              <span>Price</span>
              <strong>${{ $gig->price }}</strong>
            </div>
            <div class="hr-gig-delivery">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              {{ $gig->delivery_time }} Day Delivery
            </div>

            @if ($gig->upgrades()->count())
              <div class="hr-gig-upgrades">
                @foreach ($gig->upgrades as $key => $upgrade)
                  <label class="hr-gig-upgrade">
                    <input type="checkbox" name="upgrades" value="{{ $upgrade->uid }}" wire:model.defer="upgrades">
                    <span>
                      {{ $upgrade->title }}
                      @if ($upgrade->extra_days)
                        <span class="note">+{{ $upgrade->extra_days }} days delivery</span>
                      @else
                        <span class="note">No change to delivery time</span>
                      @endif
                    </span>
                    <span class="price">${{ $upgrade->price }}</span>
                  </label>
                @endforeach
              </div>
            @endif

            <div class="hr-gig-actions">
              <button wire:click="addToCart" wire:loading.attr="disabled" wire:target="addToCart" class="hr-btn-primary hr-cart-checkout" type="button">
                <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                <span wire:loading wire:target="addToCart" class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
              </button>
              <a class="hr-btn-outline" href="{{url('/messages/new',$gig->owner->username)}}">
                Contact Seller
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    document.getElementById("copyButton").addEventListener("click", function() {
      copyToClipboard(window.location.href);
    });

    function copyToClipboard() {
      navigator.clipboard.writeText(window.location.href);
    }
  </script>
</span>
