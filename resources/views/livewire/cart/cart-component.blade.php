@section('title')
{{ __('messages.t_shopping_cart') }}
@endsection
<span>
    <section class="hr-section hr-page-section">
      <div class="auto-container">
        @if (is_array($cart) && count($cart))

          <div class="hr-cart-head">
            <div>
              <h1>{{ __('messages.t_shopping_cart') }}</h1>
              <p>{{ __('messages.t_number_items_in_cart', ['number' => count($cart)]) }}</p>
            </div>
            <a href="{{ url('/') }}" class="hr-navlink hr-cart-continue">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
              {{ __('messages.t_continue_shopping') }}
            </a>
          </div>

          <div class="hr-cart-grid">
            <div class="hr-cart-list">
              @foreach ($cart as $key => $item)
                <div class="hr-cart-row" wire:key="item-id-{{ $key }}">
                  <img src="{{ $item['gig']['thumbnail'] }}" alt="{{ $item['gig']['title'] }}" class="hr-cart-row__img">
                  <div class="hr-cart-row__body">
                    <a href="{{ url('service', $item['gig']['slug']) }}" class="hr-cart-row__title">{{ $item['gig']['title'] }}</a>
                    <div class="hr-cart-row__meta">
                      <div class="hr-cart-qty">
                        <label>{{ __('messages.t_quantity') }}</label>
                        <input type="number" wire:model="cart.{{ $key }}.quantity" value="1" min="1" max="10">
                      </div>
                      <div class="hr-cart-row__price">@money($this->itemTotalPrice($item['id']), settings('currency')->code, true)</div>
                    </div>
                  </div>
                  <button type="button" class="hr-cart-row__remove" wire:click="remove('{{ $item['id'] }}')" aria-label="{{ __('messages.t_remove') }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                  </button>
                </div>
              @endforeach
            </div>

            <div class="hr-cart-summary">
              <h2>{{ __('messages.t_order_summary') }}</h2>
              <div class="hr-summary-row">
                <span>{{ __('messages.t_subtotal') }}</span>
                <strong>@money($this->subtotal(), settings('currency')->code, true)</strong>
              </div>
              <div class="hr-summary-row">
                <span>{{ __('messages.t_tax_estimate') }}</span>
                <strong>@money($this->taxes(), settings('currency')->code, true)</strong>
              </div>
              <div class="hr-summary-row hr-summary-row--total">
                <span>{{ __('messages.t_total') }}</span>
                <strong>@money($this->total() + $this->taxes(), settings('currency')->code, true)</strong>
              </div>
              <button wire:click="checkout" class="hr-btn-primary hr-cart-checkout">
                {{ __('messages.t_proceed_to_checkout') }}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </button>
            </div>
          </div>

        @else
          <div class="hr-cart-empty">
            <div class="hr-cart-empty__icon">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </div>
            <h2>{{ __('messages.t_ur_cart_is_empty') }}</h2>
            <p>{{ __('messages.t_ur_cart_is_empty_subtitle') }}</p>
            <a href="{{ url('/') }}" class="hr-btn-primary">
              {{ __('messages.t_continue_shopping') }} 
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
        @endif
      </div>
    </section>
</span>
