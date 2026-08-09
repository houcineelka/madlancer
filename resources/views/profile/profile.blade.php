@extends('layouts.myL')
@section('title',"Profile")
@section('main')

<section class="hr-page-section">
  <div class="auto-container">

    {{-- user availability --}}
    @if ($user->availability()->first() && $user->availability()->first()->expected_available_date > now())
      <div class="hr-alert">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <div>
          <strong>Attention needed</strong> &mdash; this user is not available right now, and will be back on {{format_date($user->availability()->first()->expected_available_date,'M d, Y')}}.
          @if ($user->availability()->first()->message)
            <br><span>{{ $user->availability()->first()->message }}</span>
          @endif
        </div>
      </div>
    @endif

    <div class="hr-profile-grid">

      {{-- USER INFORMATIONS --}}
      <div>
        <div class="hr-detail-card hr-profile-view">
          @auth
            @if (auth()->user()->id != $user->id)
              {{-- report --}}
              <span x-data="{ rep: false }">
                <button type="button" class="hr-icon-btn hr-icon-btn--danger hr-profile-view__report" title="Report user" @click="rep = !rep">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21V4"/><path d="M4 5.5c2-1.5 4-1.5 6 0s4 1.5 6 0V13c-2 1.5-4 1.5-6 0s-4-1.5-6 0V5.5z"/></svg>
                </button>
                <div x-show="rep" x-cloak>
                  @livewire('profile.report-profile',['user'=>$user])
                </div>
              </span>
            @endif
          @endauth

          <div class="hr-profile-view__avatar-wrap">
            <img src="{{ src($user->avatar) }}" class="hr-profile-view__avatar" alt="{{ $user->username }}">
            @if ($user->isOnline() && !$user->availability()->first())
              <span class="hr-status-dot hr-status-dot--online" title="Online"></span>
            @elseif ($user->availability()->first())
              <span class="hr-status-dot hr-status-dot--away" title="Unavailable"></span>
            @else
              <span class="hr-status-dot hr-status-dot--offline" title="Offline"></span>
            @endif
          </div>

          <h2 class="hr-profile-header__name">{{ Str::ucfirst($user->fullname) }}</h2>
          <p class="hr-profile-view__headline"><i>{{ $user->headline }}</i></p>
          <p class="hr-profile-header__username">{{ '@'.$user->username }}</p>
          <a class="hr-btn-primary hr-onboarding-submit" href="{{url('/messages/new',$user->username)}}">Contact me</a>
        </div>

        {{-- Description --}}
        <div class="hr-detail-card">
          <div class="hr-card-head">
            <h3>Description</h3>
          </div>
          <p class="hr-description-view">{{ $user->description }}</p>
        </div>

        {{-- More details about this user --}}
        <div class="hr-detail-card">
          <div class="hr-card-head">
            <h3>Details</h3>
          </div>
          <div class="hr-kv-list">
            <div class="hr-kv-row">
              <span class="hr-kv-label">Country</span>
              <span class="hr-kv-value">
                @if ($user->country)
                  <img src="{{ url('public/img/flags/rounded/'. $user->country->code .'.svg') }}" alt="{{ $user->country->name }}">
                @endif
                {{$user->country?->name}}
              </span>
            </div>
            <div class="hr-kv-row">
              <span class="hr-kv-label">Level</span>
              <span class="hr-kv-value">{{ $user->level?->title }}</span>
            </div>
            <div class="hr-kv-row">
              <span class="hr-kv-label">Member since</span>
              <span class="hr-kv-value">{{ $user->created_at->format('m - Y') }}</span>
            </div>
            @if ($user->account_type === 'seller' && $last_delivery)
              <div class="hr-kv-row">
                <span class="hr-kv-label">Last delivery</span>
                <span class="hr-kv-value">{{format_date($last_delivery,'ago') }}</span>
              </div>
            @endif
          </div>
        </div>

        {{-- Languages --}}
        <div class="hr-detail-card">
          <div class="hr-card-head">
            <h3>Languages</h3>
          </div>
          @if ($user->Languages->count())
            <div class="hr-chip-list">
              @foreach ($user->Languages as $lg)
                <span class="hr-chip">
                  <strong>{{ Str::ucfirst($lg->name) }}</strong> &middot; {{ Str::ucfirst($lg->level) }}
                </span>
              @endforeach
            </div>
          @else
            <p class="hr-chip-empty">No language added</p>
          @endif
        </div>

        @if ($user->skills->count())
          {{-- Skills --}}
          <div class="hr-detail-card">
            <div class="hr-card-head">
              <h3>Skills</h3>
            </div>
            @foreach ($user->skills as $sk)
              <div class="hr-chip hr-skill-chip">
                <div class="hr-skill-chip__row">
                  <span><strong>{{ Str::ucfirst($sk->name) }}</strong> &middot; {{ Str::ucfirst($sk->experience) }}</span>
                </div>
                <div class="hr-skill-bar">
                  <div class="hr-skill-bar__fill hr-skill-bar__fill--{{$sk->experience=='pro'?'pro':($sk->experience=='intermediate'?'intermediate':'beginner')}}" style="width: {{$sk->experience=='pro'?100:($sk->experience=='intermediate'?66:33)}}%"></div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      {{-- seller information --}}
      <div>
        @if ($user->account_type === 'seller')
          {{-- GIGS --}}
          <div class="hr-detail-card">
            <div class="hr-card-head">
              <h3>Gigs</h3>
            </div>

            @forelse ($gigs as $gig)
              @if ($loop->first)
                <div class="hr-gig-grid hr-gig-grid--narrow">
              @endif

              @if (in_array($gig->status, ['active', 'boosted', 'trending', 'featured']))
                <div class="hr-gig-card">
                  <div class="hr-gig-card__media">
                    <a href="{{ url('service', $gig->slug) }}">
                      <img class="lazy loaded" src="{{src($gig->thumbnail)}}" alt="{{ $gig->title }}" data-was-processed="true">
                    </a>
                    <button type="button" class="hr-gig-card__fav service-wishlist" data-id="{{ $gig->id }}" data-type="gig" aria-label="Add to favorites">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                    </button>
                  </div>
                  <div class="hr-gig-card__body">
                    <h3 class="hr-gig-card__title">
                      <a href="{{ url('service', $gig->slug) }}" class="text-reset">{{ $gig->title }}</a>
                    </h3>
                    <div class="hr-gig-card__author">
                      <img src="{{src($gig->owner->avatar)}}" alt="{{ $gig->owner->username }}">
                      <span>{{ $gig->owner->username }}</span>
                      @if($gig->owner->status === 'active')
                        <span class="hr-gig-card__verified" title="Verified seller">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.4 1.4 2.8-.3 1.3 2.5 2.5 1.3-.3 2.8L22 12l-1.4 2.4.3 2.8-2.5 1.3-1.3 2.5-2.8-.3L12 22l-2.4-1.4-2.8.3-1.3-2.5-2.5-1.3.3-2.8L2 12l1.4-2.4-.3-2.8 2.5-1.3 1.3-2.5 2.8.3L12 2z"/><path d="M9 12l2 2 4-4" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                      @endif
                    </div>
                    <div class="hr-gig-card__footer">
                      <div class="hr-gig-card__rating">
                        @if($gig->rating == 0)
                          <span>N/A</span>
                        @else
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
                          <strong>{{ $gig->rating }}</strong> ({{ number_format($gig->counter_reviews) }})
                        @endif
                      </div>
                      <div class="hr-gig-card__price">${{ $gig->price }}</div>
                    </div>
                  </div>
                </div>
              @endif

              @if ($loop->last)
                </div>
              @endif
            @empty
              <div class="hr-gig-list-empty">{{ __('no results found') }}</div>
            @endforelse

            @if ($gigs->hasPages())
              <div class="hr-pagination">
                {!! $gigs->links() !!}
              </div>
            @endif
          </div>

          <div class="hr-profile-main-row">
            {{-- PORTFOLIOS --}}
            <div class="hr-detail-card">
              <div class="hr-card-head">
                <h3>Portfolio</h3>
              </div>
              <div class="hr-portfolio-grid">
                @foreach ($user->projects as $project)
                  @if ($project->status === 'active')
                    <a href="{{ url('projects', $project->slug) }}" target="_blank" class="hr-portfolio-item">
                      <img src="{{src($project->thumbnail)}}" alt="{{ $project->title }}">
                    </a>
                  @endif
                @endforeach
              </div>
              <a href="{{ url('profile/' . $user->username . '/portfolio') }}" target="_blank" class="hr-portfolio-view-link">View my portfolio</a>
            </div>

            {{-- Linked accounts --}}
            <div class="hr-detail-card">
              <div class="hr-card-head">
                <h3>Linked accounts</h3>
              </div>
              @if ($user->accounts)
                <div class="hr-social-icons">
                  @if ($user->accounts->facebook_profile)
                    <a href="{{ $user->accounts->facebook_profile}}" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                  @endif
                  @if ($user->accounts->twitter_profile)
                    <a href="{{ $user->accounts->twitter_profile }}" target="_blank" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                  @endif
                  @if ($user->accounts->dribbble_profile)
                    <a href="{{ $user->accounts->dribbble_profile }}" target="_blank" aria-label="Dribbble"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
                  @endif
                  @if ($user->accounts->stackoverflow_profile)
                    <a href="{{ $user->accounts->stackoverflow_profile }}" target="_blank" aria-label="Stack Overflow"><i class="fab fa-stack-overflow" aria-hidden="true"></i></a>
                  @endif
                  @if ($user->accounts->github_profile)
                    <a href="{{ $user->accounts->github_profile }}" target="_blank" aria-label="GitHub"><i class="fab fa-github" aria-hidden="true"></i></a>
                  @endif
                  @if ($user->accounts->youtube_profile)
                    <a href="{{ $user->accounts->youtube_profile }}" target="_blank" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                  @endif
                  @if ($user->accounts->vimeo_profile)
                    <a href="{{ $user->accounts->vimeo_profile }}" target="_blank" aria-label="Vimeo"><i class="fab fa-vimeo" aria-hidden="true"></i></a>
                  @endif
                </div>
              @endif
            </div>
          </div>
        @endif
      </div>

    </div>
  </div>
</section>
@endsection
