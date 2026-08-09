@section('title')
{{ __('messages.t_account_settings') }}
@endsection

<section class="hr-page-section">
  <div class="auto-container">

    {{-- Loading indicator --}}
    <div class="hr-page-loading" wire:loading>
      <span class="hr-spinner"></span>
    </div>

    <div class="hr-profile-grid">

      <div wire:ignore class="hr-account-sidebar-col">
        <x-main.account.sidebar />
      </div>

      <div class="hr-detail-card">
        <div class="hr-card-head" style="display:block;">
          <h3>{{ __('messages.t_account_settings') }}</h3>
          <p style="color:var(--hr-body); font-size:13.5px; margin-top:4px;">{{ __('messages.t_account_settings_subtitle') }}</p>
        </div>

        <form>
          <div class="hr-form-row">
            {{-- username --}}
            <div class="hr-form-group">
              <label for="account-username">{{ __('messages.t_username') }}</label>
              <input class="hr-input" type="text" id="account-username" placeholder="{{ __('messages.t_enter_username') }}" wire:model.defer="username" name="username">
              @error('username') <span class="hr-field-error">{{ $message }}</span> @enderror
            </div>

            {{-- email --}}
            <div class="hr-form-group">
              <label for="account-email">{{ __('messages.t_email_address') }}</label>
              <input class="hr-input" type="text" id="account-email" placeholder="{{ __('messages.t_enter_email_address') }}" wire:model.defer="email" name="email">
              @error('email') <span class="hr-field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Fullname --}}
            <div class="hr-form-group">
              <label for="account-fn">{{ __('messages.t_fullname') }}</label>
              <input class="hr-input" type="text" id="account-fn" placeholder="{{ __('messages.t_enter_fullname') }}" wire:model.defer="fullname" name="fullname">
              @error('fullname') <span class="hr-field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Country --}}
            <div class="hr-form-group">
              <label for="account-c">{{ __('messages.t_country') }}</label>
              <select class="hr-input" wire:model.defer='country' name="country" id="account-c">
                @foreach ($countries as $c)
                  <option value="{{$c->id}}" {{ $country == $c->id ? 'selected' : '' }}>{{$c->name}}</option>
                @endforeach
              </select>
              @error('country') <span class="hr-field-error">{{ $message }}</span> @enderror
            </div>
          </div>

          {{-- Current password --}}
          <div class="hr-form-group">
            <label for="account-password">{{ __('messages.t_password') }}</label>
            <input class="hr-input" type="password" id="account-password" placeholder="{{ __('messages.t_enter_your_current_password') }}" wire:model.defer="password" name="password">
            @error('password') <span class="hr-field-error">{{ $message }}</span> @enderror
          </div>

          <div style="display:flex; justify-content:flex-end; margin-top:8px;">
            <button class="hr-btn-primary" wire:click='update' type="button">{{ __('messages.t_update') }}</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</section>
