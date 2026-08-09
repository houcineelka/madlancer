<div class="hr-chat" x-data="window.WbHObCwPcNqueuQ" x-init="init()">
  <div class="hr-chat__messages" id="msg">

    @if (count($messages))

      @if($messages->hasMorePages())
        <div class="hr-chat__loadmore">
          <button class="hr-btn-outline hr-btn-outline--sm" wire:loading.remove wire:click="loadMore">Load more messages</button>
          <span wire:loading wire:target="loadMore" class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
        </div>
      @endif

      @foreach ($messages->reverse() as $msg)
        <div class="hr-chat__row {{ $msg->message_from === auth()->id() ? 'is-mine' : '' }}" wire:key="conversation-message-{{ $msg->uid }}">
          <img src="{{ src($msg->sender->avatar) }}" alt="{{ $msg->sender->username }}" class="hr-chat__avatar">
          <div class="hr-chat__bubble-col">
            <p class="hr-chat__bubble">{{ $msg->message }}</p>
            <span class="hr-chat__time">{{ format_date($msg->created_at, 'ago') }}</span>
          </div>
        </div>
      @endforeach

      @if (!$messages->onFirstPage())
        <div class="hr-chat__loadmore">
          <button class="hr-btn-outline hr-btn-outline--sm load-previous" wire:loading.remove wire:click="loadPrevious">Load previous messages</button>
          <span wire:loading wire:target="loadPrevious" class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
        </div>
      @endif

    @else

      <div class="hr-msg-empty">
        <div class="hr-msg-empty__icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        </div>
        <h3>{{ __('messages.t_no_messages_yet') }}</h3>
        <p>{{ __('messages.t_no_messages_yet_subtitle') }}</p>
      </div>

    @endif

  </div>

  <div class="hr-chat__scrolldown-wrap">
    <button id="btnButtom" class="hr-cart-btn" style="display:none;" aria-label="Scroll to latest">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
    </button>
  </div>

  @if ($conversation->status === 'active')
    <div class="hr-chat__input">
      <img src="{{src(auth()->user()->avatar)}}" class="hr-chat__input-avatar" alt="">
      <input wire:model.defer='message' type="text" wire:keydown.enter="send" class="hr-input hr-chat__input-field" placeholder="Type a message...">
      <button class="hr-chat__send" wire:loading.remove wire:target="send" wire:click='send' aria-label="Send message">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      </button>
      <span wire:loading wire:target="send" class="hr-spinner" style="width:18px;height:18px;border-width:2px;margin-left:6px;"></span>
    </div>
  @elseif ($conversation->status === 'blocked')
    <div class="hr-chat__blocked">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      {{ __('messages.t_u_cant_reply_this_conversation') }}
    </div>
  @endif
</div>
@push('scripts')
  <script>
    $(document).ready(function() {
      $("#msg").animate({
        scrollTop: $(
        "#msg").get(0).scrollHeight
        }, 1000);

      $('#msg').scroll(function() {
        if ($(this).scrollTop() < 500) {
          $('#btnButtom').fadeIn(500);
        } else {
          $('#btnButtom').fadeOut(500);
        }
      });

      $('#btnButtom').click(function() {
        $('#msg').animate({ scrollTop: $("#msg").get(0).scrollHeight }, 'slow');
      });
    });

  </script>
  {{-- AlpineJs --}}
  <script>
    function WbHObCwPcNqueuQ() {
        return {

            init() {
                var _this = this;

                // Listen when livewire event received
                document.addEventListener("DOMContentLoaded", () => {

                    _this.scrollDown();

                    Livewire.hook('message.processed', (message, component) => {
                        _this.scrollDown();
                    })
                });

            },

            scrollDown() {
                var target = document.getElementById("msg");
                target.scrollTop = target.scrollHeight;
            }

        }
    }
    window.WbHObCwPcNqueuQ = WbHObCwPcNqueuQ();
  </script>

@endpush
