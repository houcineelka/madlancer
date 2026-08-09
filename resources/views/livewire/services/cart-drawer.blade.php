<div x-data x-cloak>

    <div class="hr-cart-drawer-wrap" role="dialog" aria-modal="true" aria-labelledby="hr-cart-drawer-title" @keydown.window.escape="$store.cart.close()" x-show="$store.cart.open" x-cloak wire:ignore.self>

        <div class="hr-cart-drawer-overlay"
            x-show="$store.cart.open"
            x-transition:enter-start="hr-cart-drawer-overlay--hidden"
            x-transition:leave-end="hr-cart-drawer-overlay--hidden"
            @click="$store.cart.close()"></div>

        <div class="hr-cart-drawer"
            x-show="$store.cart.open"
            x-transition:enter-start="hr-cart-drawer--offscreen"
            x-transition:leave-end="hr-cart-drawer--offscreen">

            <div class="hr-cart-drawer__head">
                <h2 id="hr-cart-drawer-title">{{ __('messages.t_shopping_cart') }}</h2>
                <button type="button" class="hr-cart-drawer__close" @click="$store.cart.close()" aria-label="{{ __('messages.t_close') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            @if (count($cart))
                <div class="hr-cart-drawer__body">
                    @foreach ($cart as $key => $item)
                        <div class="hr-cart-drawer__item" wire:key="item-{{ $key }}">
                            <img src="{{ $item['gig']['thumbnail'] }}" alt="{{ $item['gig']['title'] }}" class="hr-cart-drawer__item-img">
                            <div class="hr-cart-drawer__item-body">
                                <a href="{{ url('service', $item['gig']['slug']) }}" class="hr-cart-drawer__item-title">{{ $item['gig']['title'] }}</a>
                                <p class="hr-cart-drawer__item-qty">{{ __('messages.t_quantity_number', ['number' => $item['quantity']]) }}</p>
                                <div class="hr-cart-drawer__item-meta">
                                    <span class="hr-cart-drawer__item-price">@money($this->itemTotalPrice($item['id']), settings('currency')->code, true)</span>
                                    <button type="button" class="hr-cart-drawer__item-remove" wire:click="remove('{{ $item['id'] }}')">{{ __('messages.t_remove') }}</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="hr-cart-drawer__empty">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <p class="hr-cart-drawer__empty-title">{{ __('messages.t_ur_cart_is_empty') }}</p>
                    <p class="hr-cart-drawer__empty-subtitle">{{ __('messages.t_ur_cart_is_empty_subtitle') }}</p>
                </div>
            @endif

            @if (count($cart))
                <div class="hr-cart-drawer__footer">
                    <div class="hr-cart-drawer__subtotal">
                        <span>{{ __('messages.t_subtotal') }}</span>
                        <strong>@money($this->total(), settings('currency')->code, true)</strong>
                    </div>
                    <p class="hr-cart-drawer__tax-note">{{ __('messages.t_tax_fees_calculated_at_checkout') }}</p>
                    <a href="{{ url('cart') }}" class="hr-btn-primary hr-cart-drawer__checkout">{{ __('messages.t_checkout') }}</a>
                    <button type="button" class="hr-cart-drawer__continue" @click="$store.cart.close()">
                        {{ __('messages.t_continue_shopping') }}
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
