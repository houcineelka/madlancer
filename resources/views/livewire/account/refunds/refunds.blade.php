@section('title')
{{ __('messages.t_refunds') }}
@endsection

<section class="hr-page-section">
  <div class="auto-container">

    <div class="hr-page-loading" wire:loading>
      <span class="hr-spinner"></span>
    </div>

    <div class="hr-profile-grid">

      <div wire:ignore class="hr-account-sidebar-col">
        <x-main.account.sidebar />
      </div>

      <div class="hr-detail-card">
        <div class="hr-card-head" style="display:block;">
          <h3>{{ __('messages.t_refunds') }}</h3>
          <p style="color:var(--hr-body); font-size:13.5px; margin-top:4px;">{{ __('messages.t_refunds_subtitle') }}</p>
        </div>

        @forelse ($refunds as $refund)
          <a href="{{ url('account/refunds/details', $refund->uid) }}" class="hr-order-row" style="text-decoration:none; color:inherit;">
            <img src="{{ src($refund->item->gig->thumbnail) }}" alt="{{ $refund->item->gig->title }}" class="hr-order-row__thumb">
            <div class="hr-order-row__body">
              <div class="hr-order-row__title">{{ $refund->item->gig->title }}</div>
              <div class="hr-order-row__meta">
                {{ $refund->buyer_id === auth()->id() ? $refund->seller->username : $refund->buyer->username }}
                &middot; {{ format_date($refund->created_at, 'ago') }}
              </div>
            </div>
            <span class="hr-status-pill hr-status-pill--{{ $refund->status }}">{{ ucwords(str_replace('_', ' ', $refund->status)) }}</span>
          </a>
        @empty
          <p class="hr-chip-empty">No refunds yet.</p>
        @endforelse

        @if ($refunds->hasPages())
          <div class="hr-pagination">{!! $refunds->links() !!}</div>
        @endif
      </div>

    </div>
  </div>
</section>
