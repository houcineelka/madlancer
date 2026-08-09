@push('style')
    <style>
        .nav-pills-custom .nav-link {
            color: #1967d2;
            background: #fff;
            position: relative;
        }

        .nav-pills-custom .nav-link.active {
            color: #fff;
            background: #1967d2;
        }


        /* Add indicator arrow for the active tab */
        @media (min-width: 992px) {
            .nav-pills-custom .nav-link::before {
                content: '';
                display: block;
                border-top: 8px solid transparent;
                border-left: 10px solid #1967d2;
                border-bottom: 8px solid transparent;
                position: absolute;
                top: 50%;
                right: -10px;
                transform: translateY(-50%);
                opacity: 0;
            }
        }

        .nav-pills-custom .nav-link.active::before {
            opacity: 1;
        }

    </style>
@endpush
<!-- Tabs nav -->
<div class="nav flex-column shadow nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    {{-- user details --}}
    <div class="card" style="height: 40vh">
        <div class="card-body d-flex flex-column align-items-center text-center">
            <img src="{{ src(auth()->user()->avatar) }}" class="rounded-circle my-4" style="height: 100px !important" width="100px" height="100px">
            <p class="text-muted font-size-sm">
                {{"@".auth()->user()->username}}
            </p>
            <p class="d-inline-block text-center my-3">
                
                @if (auth()->user()->account_type === 'seller')
                    <a href="{{ url('seller/home') }}" class="btn btn-sm theme-btn btn-style-four badge rounded-pill ">
                        {{ __('messages.t_seller_dashboard') }}
                    </a>
                @else
                    <span class="btn btn-sm theme-btn btn-style-four badge rounded-pill">
                        {{ __('messages.t_buyer') }}
                    </span>
                @endif
            </p>
        </div>
    </div>
    {{-- sidebar links --}}
    <a class="nav-link p-3 {{ Request::is('account/settings') ? 'active' : '' }} " id="v-pills-home-tab"" href="{{ url('account/settings') }}" >
        <i class="fa fa-cog mr-2"></i>
        <span class="font-weight-bold small text-uppercase">{{ __('messages.t_account_settings') }}</span>
    </a>

    <a class="nav-link p-3 {{ Request::is('edit/profile') ? 'active' : '' }}" id="v-pills-profile-tab" href="{{ url('edit/profile') }}">
        <i class="fa fa-user mr-2"></i>
        <span class="font-weight-bold small text-uppercase">{{ __('messages.t_edit_profile') }}</span>
    </a>

    <a class="nav-link p-3 {{ Request::is('account/password') ? 'active' : '' }}" id="v-pills-messages-tab"  href="{{ url('account/password') }}">
        <i class="fa fa-lock mr-2"></i>
        <span class="font-weight-bold small text-uppercase"> {{ __('messages.t_update_password') }}</span>
    </a>
    
    <a class="nav-link p-3 {{ Request::is('account/orders') ? 'active' : '' }}" id="v-pills-messages-tab"  href="{{ url('account/orders') }}">
        <i class="fa fa-shopping-cart mr-2"></i>
        <span class="font-weight-bold small text-uppercase"> {{ __('messages.t_my_orders') }}</span>
    </a>

    <a class="nav-link p-3 {{ Request::is('account/refunds*') ? 'active' : '' }}" id="v-pills-messages-tab"  href="{{ url('account/refunds') }}">
        <i class="fa fa-reply mr-2"></i>
        <span class="font-weight-bold small text-uppercase"> {{ __('messages.t_refunds') }}</span>
    </a>

    <a class="nav-link p-3 {{ Request::is('messages') ? 'active' : '' }}" id="v-pills-messages-tab"  href="{{ url('messages') }}">
        <i class="fa fa-envelope mr-2"></i>
        <span class="font-weight-bold small text-uppercase"> {{ __('messages.t_my_messages') }}</span>
    </a>

    <a class="nav-link p-3 {{ Request::is('account/reviews') ? 'active' : '' }}" id="v-pills-messages-tab"  href="{{ url('account/reviews') }}">
        <i class="fa fa-star mr-2"></i>
        <span class="font-weight-bold small text-uppercase"> {{ __('messages.t_my_reviews') }}</span>
    </a>
    
    <a class="nav-link p-3 {{ Request::is('account/favorite') ? 'active' : '' }}" id="v-pills-messages-tab"  href="{{ url('account/favorite') }}">
        <i class="fa fa-heart mr-2"></i>
        <span class="font-weight-bold small text-uppercase"> {{ __('messages.t_favorite_list') }}</span>
    </a>

    <a class="nav-link p-3" id="v-pills-settings-tab"  href="#v-pills-settings">
        <i class="fa fa-check mr-2"></i>
        <span class="font-weight-bold small text-uppercase">Confirm booking</span>
    </a>
</div>
