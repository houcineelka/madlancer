<div class="hr-onboarding-step">
    <h3 class="hr-onboarding-step__title">Complete your profile</h3>
    @if(session('error'))
        <div class="hr-alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{session('error')}}
        </div>
    @endif
    <form class="form bravo-form-register" method="post">
        <div class="hr-form-group">
            {{-- Country --}}
            <label>Country</label>
            <select wire:model.defer='country' name="country" class="hr-input">
                @foreach ($countries as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                @endforeach
            </select>
            @error('country') <span class="hr-field-error">{{ $message }}</span>@enderror
        </div>
        <div class="hr-form-group">
            {{-- headline --}}
            <label>Headline</label>
            <input wire:model.defer='headline' type="text" class="hr-input" name="headline" autocomplete="off" placeholder="e.g. Full-Stack Developer">
            @error('headline') <span class="hr-field-error">{{ $message }}</span>@enderror
        </div>
        <div class="hr-form-group">
            {{-- Description --}}
            <label>Description</label>
            <textarea wire:model.defer='description' name="description" class="hr-input hr-textarea" placeholder="Tell us about yourself..."></textarea>
            @error('description') <span class="hr-field-error">{{ $message }}</span>@enderror
        </div>

        {{-- spinner loading --}}
        <div wire:loading.flex class="hr-onboarding-loading">
            <span class="hr-spinner"></span>
        </div>
        <div class="hr-onboarding-actions">
            <button class="hr-btn-primary hr-onboarding-submit" id="nextStep" wire:click.prevent='storeStep1()' wire:loading.attr="disabled">Next Step
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </div>
    </form>
    @if ($toNext)
        <script>
            document.getElementById('btn02').click();
        </script>
    @endif
</div>
