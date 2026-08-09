@section('title', __('messages.t_become_a_seller'))

<section class="hr-hero hr-onboarding">
  <div class="hr-hero__shapes">
    <div class="hr-shape hr-shape--dots"></div>
    <div class="hr-shape hr-shape--circle-outline"></div>
    <div class="hr-shape hr-shape--rings"></div>
    <div class="hr-shape hr-shape--dots-right"></div>
  </div>
  <div class="auto-container">
    <div class="hr-hero__inner">
      <div class="hr-badge">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.26L21 9.27l-4.5 4.38L17.8 21 12 17.77 6.2 21l1.3-7.35L3 9.27l6.1-1.01L12 2z"/></svg>
        {{ __('messages.t_become_a_seller') }}
      </div>
      <h1>{{ __('messages.t_become_a_seller') }}</h1>
      <p class="hr-hero__subtitle">{{ __('messages.t_become_a_seller_subtitle') }}</p>

      <div class="hr-onboarding-card" style="max-width:560px;">
        <p style="color:var(--hr-body); font-size:14.5px; margin-bottom:24px;">{{ __('messages.t_become_a_seller_subtitle_card') }}</p>

        <div class="hr-kv-list" style="margin-bottom:24px;">
          <div class="hr-kv-row">
            <span class="hr-kv-label">Set your own prices</span>
            <span class="hr-kv-value">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
            </span>
          </div>
          <div class="hr-kv-row">
            <span class="hr-kv-label">Publish unlimited gigs</span>
            <span class="hr-kv-value">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
            </span>
          </div>
          <div class="hr-kv-row">
            <span class="hr-kv-label">Get paid securely for delivered work</span>
            <span class="hr-kv-value">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
            </span>
          </div>
        </div>

        <div class="hr-onboarding-actions">
          <button class="hr-btn-primary hr-onboarding-submit" wire:click='confirm' wire:loading.attr="disabled" type="button">
            <span wire:loading.remove>{{ __('messages.t_become_a_seller') }}</span>
            <svg wire:loading.remove width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            <span wire:loading class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
