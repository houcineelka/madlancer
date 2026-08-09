@section('title')
{{ __('messages.t_refund_details') }}
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
        <div class="hr-detail-card">
          <div class="hr-card-head">
            <h3>{{ __('messages.t_refund_details') }}</h3>
            <span class="hr-status-pill hr-status-pill--{{ $refund->status }}">{{ ucwords(str_replace('_', ' ', $refund->status)) }}</span>
          </div>
          <p style="color:var(--hr-body); font-size:13.5px; margin-bottom:20px;">{{ __('messages.t_refund_details_subtitle') }}</p>

          <div class="hr-order-row" style="border:1px solid var(--hr-border); border-radius:var(--hr-radius-sm); padding:14px; margin-bottom:20px;">
            <img src="{{ src($refund->item->gig->thumbnail) }}" alt="{{ $refund->item->gig->title }}" class="hr-order-row__thumb">
            <div class="hr-order-row__body">
              <div class="hr-order-row__title">{{ $refund->item->gig->title }}</div>
              <div class="hr-order-row__meta">@money($refund->item->total_value, settings('currency')->code, true) &middot; {{ format_date($refund->created_at, 'F j, Y') }}</div>
            </div>
          </div>

          <div class="hr-kv-list" style="margin-bottom:20px;">
            <div class="hr-kv-row">
              <span class="hr-kv-label">{{ __('messages.t_refund_reason') }}</span>
              <span class="hr-kv-value">{{ $refund->reason }}</span>
            </div>
            <div class="hr-kv-row">
              <span class="hr-kv-label">{{ $isSeller ? 'Buyer' : 'Seller' }}</span>
              <span class="hr-kv-value">{{ $isSeller ? $refund->buyer->username : $refund->seller->username }}</span>
            </div>
          </div>

          @if ($isSeller && $refund->status === 'pending')
            <div class="hr-onboarding-actions">
              <button type="button" class="hr-btn-primary hr-onboarding-submit" wire:click="accept" wire:loading.attr="disabled">{{ __('messages.t_accept_refund') }}</button>
              <button type="button" class="hr-btn-outline hr-btn-outline--danger" wire:click="reject" wire:loading.attr="disabled">{{ __('messages.t_decline_refund') }}</button>
            </div>
          @endif

          @if (!$isSeller && $refund->status === 'rejected_by_seller' && !$refund->request_admin_intervention)
            <div class="hr-onboarding-actions">
              <button type="button" class="hr-btn-outline hr-btn-outline--danger" onclick="return confirm('{{ __('messages.t_are_u_sure_raise_dispute_refund', ['app_name' => config('app.name')]) }}')" wire:click="escalate" wire:loading.attr="disabled">{{ __('messages.t_raise_a_dispute') }}</button>
            </div>
          @endif
        </div>

        <div class="hr-detail-card">
          <div class="hr-card-head">
            <h3>Conversation</h3>
          </div>

          @forelse ($messages as $m)
            <div class="hr-chat__row {{ $m->author_id === auth()->id() ? 'is-mine' : '' }}">
              <div class="hr-chat__bubble-col">
                <div class="hr-chat__bubble">{{ $m->message }}</div>
                <span class="hr-chat__time">{{ $m->author?->username }} &middot; {{ format_date($m->created_at, 'ago') }}</span>
              </div>
            </div>
          @empty
            <p class="hr-chip-empty">No messages yet.</p>
          @endforelse

          <div class="hr-form-group" style="margin-top:16px;">
            <textarea wire:model.defer="message" class="hr-input hr-textarea" rows="3" placeholder="Write a message..."></textarea>
            @error('message') <span class="hr-field-error">{{ $message }}</span> @enderror
          </div>
          <div class="hr-onboarding-actions">
            <button type="button" class="hr-btn-primary hr-onboarding-submit" wire:click="sendMessage" wire:loading.attr="disabled">Send message</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
