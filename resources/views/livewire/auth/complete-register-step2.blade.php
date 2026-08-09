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
            {{-- avatar --}}
            <label>Profile photo</label>
            <div class="hr-onboarding-avatar">
                <img src="{{src(auth()->user()->avatar)}}" alt="" class="hr-onboarding-avatar__preview">
                <div class="hr-onboarding-avatar__controls">
                    <input wire:model.defer='avatar' type="file" class="hr-input" name="avatar">
                    @error('avatar') <span class="hr-field-error">{{ $message }}</span>@enderror
                    <button type="button" class="hr-btn-outline hr-btn-outline--sm" wire:click='addAvatar'>Upload</button>
                </div>
            </div>
        </div>

        <div class="hr-form-group">
            {{-- Languages --}}
            <label class="hr-onboarding-label-row">
                <span>Languages</span>
                <button class="hr-add-toggle" wire:click='newLang' type="button">{{$isAddLanguage?'×':'+'}}</button>
            </label>
            @if (count(auth()->user()->languages))
                <div class="hr-chip-list">
                    @foreach (auth()->user()->languages as $lg)
                        <span class="hr-chip">
                            <strong>{{$lg->name}}</strong> &middot; {{$lg->level}}
                            <button type="button" class="hr-chip__remove" wire:click='removeLang("{{$lg->name}}")' aria-label="Remove {{$lg->name}}">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </span>
                    @endforeach
                </div>
            @endif
            {{-- add language --}}
            @if ($isAddLanguage)
                <div class="hr-add-panel">
                    <select data-pharaonic="select2" data-component-id="{{ $this->id }}" wire:model.defer="add_language_name" id="select2-id-add_language_name" data-placeholder="{{ __('messages.t_choose_language') }}" data-search-off class="select2" data-dir="{{ config()->get('direction') }}" wire:ignore>
                        <option value="" selected>choose language</option>
                        @foreach (config('languages') as $code => $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('add_language_name')
                        <span class="hr-field-error">{{ $message }}</span>
                    @enderror
                    {{-- Level --}}
                    <div class="hr-radio-group">
                        <label class="hr-radio-pill">
                            <input id="languages-level-basic" wire:model.defer="add_language_level" value="basic" name="languages_level" type="radio" checked>
                            <span>Basic</span>
                        </label>
                        <label class="hr-radio-pill">
                            <input id="languages-level-conversational" wire:model.defer="add_language_level" value="conversational" name="languages_level" type="radio">
                            <span>Conversational</span>
                        </label>
                        <label class="hr-radio-pill">
                            <input id="languages-level-fluent" wire:model.defer="add_language_level" value="fluent" name="languages_level" type="radio">
                            <span>Fluent</span>
                        </label>
                        <label class="hr-radio-pill">
                            <input id="languages-level-native" wire:model.defer="add_language_level" value="native" name="languages_level" type="radio">
                            <span>Native</span>
                        </label>
                    </div>
                    @error('add_language_level')
                        <span class="hr-field-error">{{ $message }}</span>
                    @enderror
                    <button type="button" class="hr-btn-outline hr-btn-outline--sm hr-add-panel__submit" wire:click='addLang'>Add language</button>
                </div>
            @endif
        </div>
        {{-- seller information --}}
        @if (auth()->user()->account_type == 'seller')
            <div class="hr-form-group">
                {{-- Skills --}}
                <label class="hr-onboarding-label-row">
                    <span>Skills</span>
                    <button class="hr-add-toggle" wire:click='newSkill' type="button">{{$isAddSkill?'×':'+'}}</button>
                </label>
                @if (count(auth()->user()->skills))
                    <div class="hr-chip-list">
                        @foreach (auth()->user()->skills as $sk)
                            <span class="hr-chip">
                                <strong>{{$sk->name}}</strong> &middot; {{$sk->experience == 'pro' ? 'expert' : $sk->experience}}
                                <button type="button" class="hr-chip__remove" wire:click='removeSkill("{{$sk->name}}")' aria-label="Remove {{$sk->name}}">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </span>
                        @endforeach
                    </div>
                @endif
                {{-- add skill --}}
                @if ($isAddSkill)
                    <div class="hr-add-panel">
                        <input type="text" wire:model.defer="add_skill_name" id="add_skill_name" placeholder="e.g web developper" class="hr-input">
                        @error('add_skill_name')
                            <span class="hr-field-error">{{ $message }}</span>
                        @enderror
                        {{-- Level --}}
                        <div class="hr-radio-group">
                            <label class="hr-radio-pill">
                                <input wire:model.defer="add_skill_experience" value="beginner" id="beginner" name="skill_experience" type="radio" checked>
                                <span>Beginner</span>
                            </label>
                            <label class="hr-radio-pill">
                                <input wire:model.defer="add_skill_experience" value="intermediate" id="intermediate" name="skill_experience" type="radio">
                                <span>Intermediate</span>
                            </label>
                            <label class="hr-radio-pill">
                                <input wire:model.defer="add_skill_experience" value="pro" id="expert" name="skill_experience" type="radio">
                                <span>Expert</span>
                            </label>
                        </div>
                        @error('add_skill_experience')
                            <span class="hr-field-error">{{ $message }}</span>
                        @enderror
                        <button type="button" class="hr-btn-outline hr-btn-outline--sm hr-add-panel__submit" wire:click='addSkill'>Add skill</button>
                    </div>
                @endif
            </div>
        @endif
        {{-- spinner loading --}}
        <div wire:loading.flex class="hr-onboarding-loading">
            <span class="hr-spinner"></span>
        </div>
        <div class="hr-onboarding-actions">
            <button class="hr-btn-primary hr-onboarding-submit" id="nextStep" wire:click.prevent='completeRegistration()' wire:loading.attr="disabled">Finish
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
            <button class="hr-btn-outline" id="back" wire:click.prevent='goBack()' wire:loading.attr="disabled" type="button">Back</button>
        </div>
    </form>
    @if ($goBack)
        <script>
            document.getElementById('btn01').click();
        </script>
    @endif
</div>
