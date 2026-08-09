@section('title')
{{ __('messages.t_deliver_completed_work') }}
@endsection

<section class="hr-page-section">
  <div class="auto-container">

    <div class="hr-cart-head">
      <div>
        <h1>{{ __('messages.t_deliver_completed_work') }}</h1>
        <p>{{ $item->gig->title }}</p>
      </div>
    </div>

    <div class="hr-profile-main-row">

      {{-- Deliver form + history --}}
      <div class="hr-detail-card">
        <div class="hr-card-head">
          <h3>{{ __('messages.t_deliver_completed_work') }}</h3>
          <p class="hr-chip-empty" style="margin:0;">{{ __('messages.t_deliver_completed_work_subtitle') }}</p>
        </div>

        @if (in_array($item->status, ['pending', 'proceeded']) && !$item->is_finished)
          <form wire:submit.prevent="deliver">

            <div class="mb-3">
              <label class="form-label">{{ __('messages.t_delivered_work') }}</label>
              <input type="file" wire:model="work" class="form-control">
              <div wire:loading wire:target="work">{{ __('messages.t_uploading') }}...</div>
              @error('work') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">{{ __('messages.t_quick_response') }}</label>
              <textarea wire:model.defer="quick_response" class="form-control" rows="4"></textarea>
              @error('quick_response') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="hr-btn-primary" wire:loading.attr="disabled" wire:target="deliver">
              {{ __('messages.t_deliver_work') }}
            </button>

          </form>
        @else
          <p class="hr-chip-empty">{{ __('messages.t_this_order_already_finished_cant_deliver') }}</p>
        @endif

        @if ($deliveries->count())
          <div class="hr-card-head" style="margin-top: 24px;">
            <h3>{{ __('messages.t_last_delivery') }}</h3>
          </div>
          @foreach ($deliveries as $delivery)
            <div class="hr-order-row">
              <div class="hr-order-row__body">
                <div class="hr-order-row__meta">{{ format_date($delivery->created_at, 'F j, Y h:i A') }}</div>
                @if ($delivery->quick_response)
                  <div class="hr-order-row__title">{{ $delivery->quick_response }}</div>
                @endif
              </div>
              @if ($delivery->attached_work)
                <a href="{{ url('orders/delivered/download', [$item->order->uid, $item->uid, $delivery->id, $delivery->attached_work['id']]) }}" class="hr-btn-outline" style="width:auto; padding-left:16px; padding-right:16px;">
                  {{ __('messages.t_delivered_work') }}
                </a>
              @endif
            </div>
          @endforeach
        @endif

      </div>

      {{-- Conversation --}}
      <div class="hr-detail-card">
        <div class="hr-card-head">
          <h3>{{ __('messages.t_messages') }}</h3>
        </div>

        <div style="max-height: 400px; overflow-y:auto;">
          @forelse ($conversation as $msg)
            <div class="hr-order-row">
              <div class="hr-order-row__body">
                <div class="hr-order-row__meta">{{ $msg->from->username }} &middot; {{ format_date($msg->created_at, 'F j, Y h:i A') }}</div>
                <div class="hr-order-row__title">{{ $msg->msg_content }}</div>
              </div>
            </div>
          @empty
            <p class="hr-chip-empty">{{ __('messages.t_no_messages_yet') }}</p>
          @endforelse
        </div>

        <form wire:submit.prevent="send" style="margin-top: 16px;">
          <div class="mb-3">
            <textarea wire:model.defer="message" class="form-control" rows="3"></textarea>
            @error('message') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
          <button type="submit" class="hr-btn-primary" wire:loading.attr="disabled" wire:target="send">
            {{ __('messages.t_send') }}
          </button>
        </form>

      </div>

    </div>

  </div>
</section>
