@section('title')
{{ __('messages.t_seller_dashboard') }}
@endsection

<section class="hr-page-section">
  <div class="auto-container">

    <div class="hr-cart-head">
      <div>
        <h1>{{ __('messages.t_seller_dashboard') }}</h1>
        <p>{{ '@'.auth()->user()->username }}</p>
      </div>
    </div>

    <div class="hr-stat-grid">
      <div class="hr-stat-card">
        <div class="hr-stat-card__icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="hr-stat-card__value">@money(auth()->user()->balance_available, settings('currency')->code, true)</div>
        <div class="hr-stat-card__label">Available balance</div>
      </div>
      <div class="hr-stat-card">
        <div class="hr-stat-card__icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="hr-stat-card__value">@money(auth()->user()->balance_pending, settings('currency')->code, true)</div>
        <div class="hr-stat-card__label">Pending balance</div>
      </div>
      <div class="hr-stat-card">
        <div class="hr-stat-card__icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg>
        </div>
        <div class="hr-stat-card__value">{{ $gigsCount }}</div>
        <div class="hr-stat-card__label">Gigs</div>
      </div>
      <div class="hr-stat-card">
        <div class="hr-stat-card__icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <div class="hr-stat-card__value">{{ $ordersQueue }}</div>
        <div class="hr-stat-card__label">Orders in queue</div>
      </div>
    </div>

    <div class="hr-profile-main-row">
      <div class="hr-detail-card">
        <div class="hr-card-head">
          <h3>Your gigs</h3>
        </div>
        @if ($gigs->count())
          <div class="hr-gig-grid hr-gig-grid--narrow">
            @foreach ($gigs as $g)
              <div class="hr-gig-card">
                <div class="hr-gig-card__media">
                  <a href="{{ url('service', $g->slug) }}">
                    <img class="lazy loaded" src="{{src($g->thumbnail)}}" alt="{{ $g->title }}">
                  </a>
                </div>
                <div class="hr-gig-card__body">
                  <h3 class="hr-gig-card__title">
                    <a href="{{ url('service', $g->slug) }}" class="text-reset">{{ $g->title }}</a>
                  </h3>
                  <div class="hr-gig-card__footer">
                    <span class="hr-status-pill hr-status-pill--{{ $g->status }}">{{ $g->status }}</span>
                    <div class="hr-gig-card__price">${{ $g->price }}</div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="hr-chip-empty">You haven't published any gigs yet.</p>
        @endif
      </div>

      <div class="hr-detail-card">
        <div class="hr-card-head">
          <h3>Recent orders</h3>
        </div>
        @forelse ($recentOrders as $item)
          <a href="{{ url('seller/orders/details', $item->uid) }}" class="hr-order-row" style="text-decoration:none; color:inherit;">
            <img src="{{ src($item->gig->thumbnail) }}" alt="{{ $item->gig->title }}" class="hr-order-row__thumb">
            <div class="hr-order-row__body">
              <div class="hr-order-row__title">{{ $item->gig->title }}</div>
              <div class="hr-order-row__meta">@money($item->total_value, settings('currency')->code, true) &middot; {{ format_date($item->placed_at, 'ago') }}</div>
            </div>
            <span class="hr-status-pill hr-status-pill--{{ $item->status }}">
              @switch($item->status)
                @case('pending') {{ __('messages.t_pending') }} @break
                @case('proceeded') {{ __('messages.t_in_the_process') }} @break
                @case('delivered') {{ __('messages.t_delivered') }} @break
                @case('canceled') {{ __('messages.t_canceled') }} @break
                @case('refunded') {{ __('messages.t_refunded') }} @break
                @default {{ $item->status }}
              @endswitch
            </span>
          </a>
        @empty
          <p class="hr-chip-empty">No orders yet.</p>
        @endforelse
      </div>
    </div>

  </div>
</section>
