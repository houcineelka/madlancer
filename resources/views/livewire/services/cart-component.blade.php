<span x-data x-cloak>

    <button type="button" class="hr-cart-btn ms-4" @click="$store.cart.toggle()" aria-label="{{ __('messages.t_shopping_cart') }}" wire:key="cart-toggle-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"/>
            <circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        @if (count($cart))
            <span class="hr-cart-btn__badge">{{ count($cart) }}</span>
        @endif
    </button>
</span>
