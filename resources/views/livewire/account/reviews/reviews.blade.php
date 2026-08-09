@section('title')
{{ __('messages.t_my_reviews') }}
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

      <div>
        @if ($received !== null)
          <div class="hr-detail-card">
            <div class="hr-card-head" style="display:block;">
              <h3>{{ __('messages.t_reviews') }}</h3>
              <p style="color:var(--hr-body); font-size:13.5px; margin-top:4px;">{{ __('messages.t_u_have_received_new_rating') }}</p>
            </div>

            @forelse ($received as $review)
              <div class="hr-chip hr-skill-chip" style="margin-bottom:12px;">
                <div class="hr-skill-chip__row">
                  <span style="display:flex; align-items:center; gap:10px;">
                    <img src="{{ src($review->user->avatar) }}" alt="{{ $review->user->username }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                    <span>
                      <strong>{{ $review->user->username }}</strong>
                      <span style="color:var(--hr-body); font-size:12.5px; display:block;">{{ format_date($review->created_at, 'ago') }}</span>
                    </span>
                  </span>
                  <span style="color:var(--hr-star); display:flex; gap:1px;">
                    @for ($i = 1; $i <= 5; $i++)
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
                    @endfor
                  </span>
                </div>
                @if ($review->message)
                  <p style="color:var(--hr-body); font-size:14px; margin-top:10px;">{{ $review->message }}</p>
                @endif
                <a href="{{ url('service', $review->gig->slug) }}" class="hr-tag" style="margin-top:10px; display:inline-block;">{{ $review->gig->title }}</a>
              </div>
            @empty
              <p class="hr-chip-empty">No reviews yet.</p>
            @endforelse

            @if ($received->hasPages())
              <div class="hr-pagination">{!! $received->links() !!}</div>
            @endif
          </div>
        @endif

        <div class="hr-detail-card">
          <div class="hr-card-head" style="display:block;">
            <h3>{{ __('messages.t_my_reviews') }}</h3>
            <p style="color:var(--hr-body); font-size:13.5px; margin-top:4px;">{{ __('messages.t_account_reviews_subtitle') }}</p>
          </div>

          @forelse ($written as $review)
            <div class="hr-chip hr-skill-chip" style="margin-bottom:12px;">
              <div class="hr-skill-chip__row">
                <span style="display:flex; align-items:center; gap:10px;">
                  <img src="{{ src($review->seller->avatar) }}" alt="{{ $review->seller->username }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                  <span>
                    <strong>{{ $review->seller->username }}</strong>
                    <span style="color:var(--hr-body); font-size:12.5px; display:block;">{{ format_date($review->created_at, 'ago') }}</span>
                  </span>
                </span>
                <span style="color:var(--hr-star); display:flex; gap:1px;">
                  @for ($i = 1; $i <= 5; $i++)
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
                  @endfor
                </span>
              </div>
              @if ($review->message)
                <p style="color:var(--hr-body); font-size:14px; margin-top:10px;">{{ $review->message }}</p>
              @endif
              <a href="{{ url('service', $review->gig->slug) }}" class="hr-tag" style="margin-top:10px; display:inline-block;">{{ $review->gig->title }}</a>
            </div>
          @empty
            <p class="hr-chip-empty">No reviews yet.</p>
          @endforelse

          @if ($written->hasPages())
            <div class="hr-pagination">{!! $written->links() !!}</div>
          @endif
        </div>
      </div>

    </div>
  </div>
</section>
