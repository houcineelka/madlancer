@section('title')
{{ __('messages.t_order_details') }}
@endsection

<section class="hr-page-section">
  <div class="auto-container">

    <div class="hr-cart-head">
      <div>
        <h1>{{ __('messages.t_order_details') }}</h1>
        <p>{{ $item->gig->title }}</p>
      </div>
    </div>

    <div class="hr-profile-main-row">

      <div class="hr-detail-card">
        <div class="hr-card-head">
          <h3>{{ __('messages.t_order_details') }}</h3>
        </div>

        <div class="hr-order-row">
          <img src="{{ src($item->gig->thumbnail) }}" alt="{{ $item->gig->title }}" class="hr-order-row__thumb">
          <div class="hr-order-row__body">
            <div class="hr-order-row__title">
              <a href="{{ url('service', $item->gig->slug) }}" target="_blank" class="text-reset">{{ $item->gig->title }}</a>
            </div>
            <div class="hr-order-row__meta">{{ __('messages.t_date_placed') }}: {{ format_date($item->placed_at, 'F j, Y h:i A') }}</div>
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
        </div>

        <div class="hr-stat-grid" style="margin-top: 20px;">
          <div class="hr-stat-card">
            <div class="hr-stat-card__value">@money($item->total_value, settings('currency')->code, true)</div>
            <div class="hr-stat-card__label">{{ __('messages.t_total') }}</div>
          </div>
          <div class="hr-stat-card">
            <div class="hr-stat-card__value">@money($item->profit_value, settings('currency')->code, true)</div>
            <div class="hr-stat-card__label">{{ __('messages.t_earnings') }}</div>
          </div>
          <div class="hr-stat-card">
            <div class="hr-stat-card__value">{{ $item->quantity }}</div>
            <div class="hr-stat-card__label">{{ __('messages.t_quantity') }}</div>
          </div>
          <div class="hr-stat-card">
            <div class="hr-stat-card__value">
              @if ($item->expected_delivery_date)
                {{ format_date($item->expected_delivery_date, 'F j, Y') }}
              @else
                &mdash;
              @endif
            </div>
            <div class="hr-stat-card__label">{{ __('messages.t_expected_delivery_date') }}</div>
          </div>
        </div>

        @if ($item->has('upgrades'))
          <div class="hr-card-head" style="margin-top: 20px;">
            <h3>{{ __('messages.t_upgrades') }}</h3>
          </div>
          @foreach ($item->upgrades as $upgrade)
            <div class="hr-order-row">
              <div class="hr-order-row__body">
                <div class="hr-order-row__title">{{ $upgrade->title }}</div>
              </div>
              <span>+ @money($upgrade->price, settings('currency')->code, true)</span>
            </div>
          @endforeach
        @endif

        <div style="margin-top: 24px; display: flex; gap: 12px;">
          <a href="{{ url('messages/new', $item->order->buyer->username) }}" class="hr-btn-outline" style="width: auto; padding-left: 24px; padding-right: 24px;">
            {{ __('messages.t_contact_buyer') }}
          </a>

          @if (in_array($item->status, ['pending', 'proceeded']) && !$item->is_finished)
            <a href="{{ url('seller/orders/deliver', $item->uid) }}" class="hr-btn-primary">
              {{ __('messages.t_deliver_work') }}
            </a>
          @elseif ($item->status === 'delivered')
            <a href="{{ url('seller/orders/deliver', $item->uid) }}" class="hr-btn-outline" style="width: auto; padding-left: 24px; padding-right: 24px;">
              {{ __('messages.t_view_delivered_work') }}
            </a>
          @endif
        </div>

      </div>

    </div>

  </div>
</section>
