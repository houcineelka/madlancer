@section('title','Messages')

<div class="hr-section hr-page-section">
  <div class="auto-container">
    <div class="hr-msg-shell">

      <div class="hr-msg-list">
        <div class="hr-msg-list__head">
          <h2>Messages</h2>
        </div>
        <div class="hr-msg-list__items">
          @forelse ($conversations as $c)
            @php($latest = $c->messages()->latest()->first())
            <a href="{{ url('messages', $c->uid) }}" wire:key="conversation-id-{{ $c->uid }}" class="hr-msg-item {{ (request('conversationId') == $c->uid || $currentConv?->uid === $c->uid) ? 'is-active' : '' }}">
              <span class="hr-msg-item__avatar">
                <img src="{{ src($c->sender->avatar) }}" alt="{{ $c->sender->username }}">
                <span class="hr-msg-item__status {{ $c->sender->isOnline() ? 'is-online' : '' }}"></span>
              </span>
              <span class="hr-msg-item__body">
                <span class="hr-msg-item__row">
                  <strong>{{ $c->sender->fullname }}</strong>
                  @if ($latest)
                    <span class="hr-msg-item__time">{{ format_date($latest->created_at) }}</span>
                  @endif
                </span>
                @if ($latest)
                  <span class="hr-msg-item__preview">{{ $latest->message }}</span>
                @endif
              </span>
              @if ($c->unreadMessages()->count() > 0)
                <span class="hr-msg-item__badge">{{ $c->unreadMessages()->count() }}</span>
              @endif
            </a>
          @empty
            <p class="hr-empty-note">No conversations yet.</p>
          @endforelse
        </div>
      </div>

      <div class="hr-msg-panel">
        @if ($currentConv)
          <div class="hr-msg-panel__head">
            <div class="hr-msg-panel__user">
              <img src="{{ src($currentConv->sender->avatar) }}" alt="{{ $currentConv->sender->username }}">
              <div>
                <strong>{{ $currentConv->sender->fullname }}</strong>
                <div class="hr-msg-panel__meta">
                  <span>{{ '@'.$currentConv->sender->username }}</span>
                  <span>&middot;</span>
                  @if ($currentConv->sender->country)
                    <img src="{{ url('public/img/flags/rounded/'. $currentConv->sender->country->code .'.svg') }}" alt="{{ $currentConv->sender->country->name }}">
                    <span>{{ $currentConv->sender->country->name }}</span>
                    <span>&middot;</span>
                  @endif
                  <span>Member since {{ $currentConv->sender->created_at->format('M Y') }}</span>
                </div>
              </div>
            </div>
            <div class="hr-msg-panel__actions">
              <a href="{{route('profileVisitor',$currentConv->sender->username)}}" class="hr-btn-outline hr-btn-outline--sm">View Profile</a>
              @if ($currentConv->status !== 'blocked')
                <button class="hr-btn-outline hr-btn-outline--sm hr-btn-outline--danger" wire:click='block' wire:loading.remove wire:target="block">{{ __('messages.t_block_user') }}</button>
                <span wire:loading wire:target="block" class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
              @elseif ($currentConv->blocked_by === auth()->id())
                <button class="hr-btn-outline hr-btn-outline--sm" wire:click='unblock' wire:loading.remove wire:target="unblock">{{ __('messages.t_unblock_user') }}</button>
                <span wire:loading wire:target="unblock" class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
              @endif
            </div>
          </div>

          @livewire('messages.conversation-component', ['conversationId' => request("conversationId") ?? $currentConv->uid])
        @else
          <div class="hr-msg-empty">
            <div class="hr-msg-empty__icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <h3>No conversation selected</h3>
            <p>Please select a conversation to start messaging.</p>
          </div>
        @endif
      </div>

    </div>
  </div>
</div>
