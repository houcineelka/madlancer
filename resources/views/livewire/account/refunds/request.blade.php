@section('title')
{{ __('messages.t_request_refund') }}
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

      <div class="hr-detail-card" style="max-width:640px;">
        <div class="hr-card-head" style="display:block;">
          <h3>{{ __('messages.t_request_refund') }}</h3>
          <p style="color:var(--hr-body); font-size:13.5px; margin-top:4px;">{{ __('messages.t_request_refund_subtitle') }}</p>
        </div>

        <div class="hr-order-row" style="border:1px solid var(--hr-border); border-radius:var(--hr-radius-sm); padding:14px; margin-bottom:20px;">
          <img src="{{ src($item->gig->thumbnail) }}" alt="{{ $item->gig->title }}" class="hr-order-row__thumb">
          <div class="hr-order-row__body">
            <div class="hr-order-row__title">{{ $item->gig->title }}</div>
            <div class="hr-order-row__meta">@money($item->total_value, settings('currency')->code, true)</div>
          </div>
        </div>

        @if (!$canRefund)
          <div class="hr-alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{ __('messages.t_u_cant_request_refund_for_this_item_now') }}
          </div>
        @else
          <div class="hr-form-group">
            <label>{{ __('messages.t_refund_reason') }}</label>
            <textarea wire:model.defer="reason" class="hr-input hr-textarea" rows="6"></textarea>
            @error('reason') <span class="hr-field-error">{{ $message }}</span> @enderror
          </div>

          <div class="hr-onboarding-actions">
            <button class="hr-btn-primary hr-onboarding-submit" wire:click='submit' wire:loading.attr="disabled" type="button">
              <span wire:loading.remove>{{ __('messages.t_request_refund') }}</span>
              <span wire:loading class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
            </button>
          </div>
        @endif
      </div>

    </div>
  </div>
</section>
