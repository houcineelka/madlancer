<div class="fixed-top">
  <header class="main-header bg-light">
    <div class="main-box">
      <div class="nav-outer">
        <div class="logo-box">
          <div class="logo">
            <a href="{{url('/')}}" class="hr-logo">
              <span class="hr-logo__mad">Mad</span><span class="hr-logo__lancer">Lancer</span>
            </a>
          </div>
        </div>
        {{-- NAVBAR --}}
        <nav class="nav main-menu">
          <ul class="navigation" id="navbar">
            <li class="dropdown depth-0">
              <a target="" href="{{ url('category/all') }}"
                >Categories<i class="caret flaticon-down-arrow"></i
              ></a>
              <ul class="children-menu menu-dropdown">
                  @foreach ($categories as $cat)
                      <li class="dropdown depth-1">
                          <a target="" href= "{{ url('categories/' . $cat->slug) }}"
                          >{{$cat->name}} <i class="caret flaticon-down-arrow"></i
                          ></a>
                          <ul class="children-menu menu-dropdown">

                              @foreach ($cat->subcategories as $sub)
                                      <li class="depth-2">
                                          <a target="{{$sub->name}}" href="{{ url('categories/' . $cat->slug . '/' . $sub->slug) }}">{{$sub->name}}</a>
                                      </li>
                              @endforeach

                          </ul>
                      </li>

                  @endforeach
              </ul>
            </li>
            
            <li class="dropdown depth-0">
              <a target="" href="{{ url('/') }}#how-it-works">How It Works</a>
            </li>
            <li class="dropdown depth-0">
              <a target="" href="{{url('/contact')}}">Contact</a>
            </li>
          </ul>
        </nav>

      </div>
      <div class="elementor-widget-wrap elementor-element-populated">
      <div class="outer-box">
      


        {{-- cart component --}}
        <livewire:services.cart-component />

        {{-- auth test --}}
        @auth
        {{-- messages --}}
          <a href="{{route('messages')}}" class="hr-cart-btn ms-4" aria-label="Messages">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="4" width="20" height="16" rx="2"/>
              <path d="M22 6l-10 7L2 6"/>
            </svg>
            @if(($new_messages??0) > 0)
              <span class="hr-cart-btn__badge">{{$new_messages}}</span>
            @endif
          </a>
        {{-- notification --}}
        <livewire:partials.notifications />

        {{-- profile --}}

        <div class="action m-4">
          <div class="profile hr-avatar-btn" onclick="menuToggle();">
              <img style="width: 100%;" src="{{src(auth()->user()->avatar )}}" >
          </div>

          <div class="menu hr-profile-menu">
              <h3>
                  {{auth()->user()->fullname}}
                  <div>
                    {{auth()->user()->balance_available}} $
                  </div>
              </h3>
              <ul class="overflow-auto">
                  @if(auth()->user()->account_type == "seller")
                  <li>
                    <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29a1 1 0 0 0 1.41 0l8.59-8.59a1 1 0 0 0 0-1.41L12 2Z"/><circle cx="7" cy="7" r="1.5" fill="currentColor" stroke="none"/></svg></span>
                    <a href="{{ url('seller/home') }}">Seller dashboard</a>
                  </li>

                  @else
                  <li>
                    <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 2.1l4 4-4 4"/><path d="M3 12.2v-2a4 4 0 0 1 4-4h14"/><path d="M7 21.9l-4-4 4-4"/><path d="M21 11.8v2a4 4 0 0 1-4 4H3"/></svg></span>
                    <a href="{{ url('become-seller') }}">Become a seller</a>
                  </li>
                  @endif
                  <li>
                      <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg></span>
                      <a href="{{route('profile')}}">My Profile</a>
                  </li>
                  <li>
                      <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg></span>
                      <a href="{{route('editProfile')}}">Edit Account</a>
                  </li>
                  <li>
                      <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg></span>
                      <a href="{{url('/account/settings')}}">Account Settings</a>
                  </li>
                 
                  <li>
                      <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
                      <a href="{{ url('account/orders') }}">My orders</a>
                  </li>
                  <li>
                    <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/></svg></span>
                    <a href="{{route('messages')}}">Messages</a>
                    @if(($new_messages??0) > 0)
                      <span class="hr-menu-badge">{{$new_messages}}</span>
                    @endif
                  </li>
                  <li>
                    <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
                    <a href="{{ url('account/reviews') }}">Reviews</a>
                  </li>
                  <li>
                    <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"/></svg></span>
                    <a href="{{ url('account/refunds') }}">Refunds</a>
                  </li>

                  <li class="hr-menu-item--danger">
                      <span class="hr-menu-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></span>
                      <a href="{{ url('/logout')}}">Log out</a>
                  </li>
              </ul>
          </div>
      </div>
        @endauth
        {{-- guest --}}
        @guest
          <div class="btn-box d-flex align-items-center" x-data="{ open: {{session('log') ?? 'false'}},open2:false }">

                <a href="#" class="hr-navlink me-3 bc-call-modal signup" @click.prevent="open2 = !open2">Register</a>

                <button class="hr-btn-login" @click="open = !open">
                  <span class="bc-call-modal login">Login</span>
                  <span class="hr-arrow">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </button>


                <div x-show="open"  x-cloak>
                  <livewire:login-modal/>
                </div>
                <div x-show="open2" x-cloak>
                  <livewire:register-modal/>
                </div>

          </div>
        @endguest
      </div>
    </div></div>

    <div class="mobile-header">
      <div class="logo">
        <a href="{{ url('/') }}">
          <img src="{{ asset('uploads/demo/general/logo.svg') }}" alt="" />
        </a>
      </div>

      <div class="nav-outer clearfix">
        <div class="outer-box">
          <div class="login-box">
            <a href="#" class="bc-call-modal login"
              ><span class="icon-user"></span
            ></a>
          </div>
          <a href="#nav-mobile" class="mobile-nav-toggler"
            ><span class="flaticon-menu-1"></span
          ></a>
        </div>
      </div>
    </div>
   
  
  </header>

  
  </div>
  