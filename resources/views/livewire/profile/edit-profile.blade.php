@section('title'," Edit profile")
<div x-data="window.TJPlQeqplTFcTQC" x-init="init()">

  {{-- Loading indicator --}}
  <div class="hr-page-loading" wire:loading>
    <span class="hr-spinner"></span>
  </div>

  <section class="hr-page-section">
    <div class="auto-container">

      <div class="hr-cart-head">
        <div>
          <h1>Edit profile</h1>
          <p>Manage how you appear across MadLancer</p>
        </div>
      </div>

      <div class="hr-profile-grid">

        {{-- USER INFORMATIONS --}}
        <div>
          {{-- Avatar image + headline --}}
          <div class="hr-detail-card hr-profile-header">
            <div class="hr-profile-header__avatar-wrap" x-data="{open:false}">
              <img src="{{src(auth()->user()->avatar)}}" class="hr-profile-header__avatar" alt="" @mouseover="open=true">
              <label for="profile-avatar-container" class="hr-profile-header__avatar-overlay" x-show="open" x-cloak @mouseleave="open=false">
                Change
                <input type="file" id="profile-avatar-container" wire:model="avatar" @change="avatar">
              </label>
            </div>

            <h2 class="hr-profile-header__name">{{ Str::ucfirst(auth()->user()->fullname) }}</h2>

            {{-- edit headline preview --}}
            <div class="hr-profile-header__headline-row" @click="toggleEditingHeadline" x-show="!isHeadlineEditing" role="button" tabindex="0">
              <span><i>{{ auth()->user()->headline }}</i></span>
              <button type="button" class="hr-icon-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              </button>
            </div>

            {{-- Edit headline (Form) --}}
            <div x-show="isHeadlineEditing" x-cloak style="text-align:left;">
              <input type="text" wire:model.defer="headline" @click.outside="disableEditing" @keydown.enter="disableEditing" @keydown.window.escape="disableEditing" class="hr-input" x-ref="edit_headline" maxlength="100">

              <div class="hr-onboarding-actions" style="margin-top:10px;">
                <button wire:click="setHeadline" wire:loading.attr="disabled" wire:target="setHeadline" type="button" class="hr-btn-primary hr-btn-primary--sm">
                  <span wire:loading wire:target="setHeadline" class="hr-spinner" style="width:13px;height:13px;border-width:2px;"></span>
                  <svg wire:loading.remove wire:target="setHeadline" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                  Approve
                </button>
                <button @click="disableEditing" type="button" class="hr-btn-outline hr-btn-outline--sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                  Cancel
                </button>
              </div>
            </div>

            <p class="hr-profile-header__username">{{ '@'.auth()->user()->username }}</p>
            <a class="hr-btn-outline" href="{{route('profileVisitor',auth()->user()->username)}}">See as visitor</a>
          </div>

          {{-- More details about this user --}}
          <div class="hr-detail-card">
            <div class="hr-card-head">
              <h3>Details</h3>
            </div>
            <div class="hr-kv-list">
              <div class="hr-kv-row">
                <span class="hr-kv-label">Country</span>
                <span class="hr-kv-value">
                  @if (auth()->user()->country)
                    <img src="{{ url('public/img/flags/rounded/'. auth()->user()->country->code .'.svg') }}" alt="{{ auth()->user()->country->name }}">
                  @endif
                  {{auth()->user()->country?->name}}
                </span>
              </div>
              <div class="hr-kv-row">
                <span class="hr-kv-label">Level</span>
                <span class="hr-kv-value">{{ auth()->user()->level?->title }}</span>
              </div>
              <div class="hr-kv-row">
                <span class="hr-kv-label">Member since</span>
                <span class="hr-kv-value">{{ auth()->user()->created_at->format('m - Y') }}</span>
              </div>
            </div>
          </div>

          {{-- Set availability --}}
          @if (auth()->user()->account_type === 'seller')
            <div class="hr-detail-card" x-data="{open02: false}">
              <div class="hr-availability-head">
                <div>
                  <h3 style="margin-bottom:4px;">Availability</h3>
                  <p>When unavailable, you won't be able to receive new orders</p>
                </div>
                @if (!$availability)
                  <button type="button" id="modal-set-availability-button" @click="open02 = true" class="hr-availability-trigger">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Set availability
                  </button>
                @endif
              </div>

              @if ($availability)
                <div class="hr-availability-banner">
                  <span class="hr-badge-danger">Unavailable</span>
                  <p class="hr-availability-note">You won't be able to receive orders until <strong>{{format_date($availability->expected_available_date,'M d, Y')}}</strong></p>
                  <div class="hr-availability-quote">
                    <p>{{ $availability->message }}</p>
                    <div class="hr-availability-quote__author">
                      <img src="{{src(auth()->user()->avatar)}}" alt="">
                      <span>{{ auth()->user()->username }}</span>
                    </div>
                  </div>
                  <div class="hr-onboarding-actions" style="margin-top:14px;">
                    <button type="button" class="hr-btn-outline hr-btn-outline--sm" wire:click="removeAvailability">Change</button>
                  </div>
                </div>
              @endif

              {{-- Set availability modal --}}
              @if (!$availability)
                <div class="hr-modal-backdrop" x-show="open02" id="modal-set-availability-container" x-cloak>
                  <div class="hr-modal-card">
                    <button type="button" class="hr-modal-close" @click="open02 = false">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <h3>Change availability</h3>
                    <form method="post">
                      <div class="hr-form-group">
                        <label>When do you expect to be ready for new work?</label>
                        <input type="date" class="hr-input" wire:model.defer="availability_date" name="availability_date" placeholder="dd/mm/yy example : {{now()->addDay()->format('d/m/Y')}}">
                        @error('availability_date') <span class="hr-field-error">{{$message}}</span> @enderror
                      </div>
                      <div class="hr-form-group">
                        <label>Add a message</label>
                        <textarea class="hr-input hr-textarea" wire:model.defer="availability_message" name="availability_message"></textarea>
                        @error('availability_message') <span class="hr-field-error">{{$message}}</span> @enderror
                      </div>
                      {{-- spinner loading --}}
                      <div wire:loading.flex class="hr-onboarding-loading">
                        <span class="hr-spinner"></span>
                      </div>
                      <div class="hr-onboarding-actions">
                        <button class="hr-btn-primary hr-onboarding-submit" name="setAvailability" wire:click.prevent="setAvailability()" wire:loading.attr="disabled" type="button">Set availability</button>
                      </div>
                    </form>
                  </div>
                </div>
              @endif
            </div>
          @endif

          {{-- Description --}}
          <div class="hr-detail-card">
            <div class="hr-card-head">
              <h3>Description</h3>
              <button type="button" class="hr-icon-btn" @click="isDescriptionEditing = !isDescriptionEditing">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              </button>
            </div>

            <div x-show="!isDescriptionEditing">
              <p class="hr-description-view">{{auth()->user()->description}}</p>
            </div>

            {{-- Edit Description (Form) --}}
            <div x-show="isDescriptionEditing" x-cloak>
              <textarea wire:model.defer="description" class="hr-input hr-textarea" rows="8" style="min-height:180px;"></textarea>
              @error('description') <span class="hr-field-error">{{ $message }}</span> @enderror

              <div class="hr-onboarding-actions" style="margin-top:12px;">
                <button wire:click="updateDescription" wire:loading.attr="disabled" wire:target="updateDescription" type="button" class="hr-btn-primary hr-btn-primary--sm">
                  <span wire:loading wire:target="updateDescription" class="hr-spinner" style="width:13px;height:13px;border-width:2px;"></span>
                  <svg wire:loading.remove wire:target="updateDescription" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                  Update
                </button>
                <button @click="isDescriptionEditing = false" type="button" class="hr-btn-outline hr-btn-outline--sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                  Cancel
                </button>
              </div>
            </div>
          </div>

          {{-- Languages --}}
          <div class="hr-detail-card">
            <div class="hr-card-head">
              <h3>Languages</h3>
              <button type="button" class="hr-add-toggle" @click="isAddLanguage = !isAddLanguage">
                <span x-show="!isAddLanguage">+</span>
                <span x-show="isAddLanguage" x-cloak>&times;</span>
              </button>
            </div>

            <div x-show="isAddLanguage" x-cloak class="hr-add-panel">
              <select data-component-id="{{ $this->id }}" wire:model.defer="add_language.name" id="select2-id-add_language.name" data-placeholder="choose language" data-search-off class="select2 hr-input">
                <option value="" selected>choose language</option>
                @foreach (config('languages') as $code => $name)
                  <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
              </select>
              @error('add_language.name') <span class="hr-field-error">{{ $message }}</span> @enderror

              <div class="hr-radio-group">
                <label class="hr-radio-pill"><input id="languages-level-basic" wire:model.defer="add_language.level" value="basic" name="languages_level" type="radio" checked><span>Basic</span></label>
                <label class="hr-radio-pill"><input id="languages-level-conversational" wire:model.defer="add_language.level" value="conversational" name="languages_level" type="radio"><span>Conversational</span></label>
                <label class="hr-radio-pill"><input id="languages-level-fluent" wire:model.defer="add_language.level" value="fluent" name="languages_level" type="radio"><span>Fluent</span></label>
                <label class="hr-radio-pill"><input id="languages-level-native" wire:model.defer="add_language.level" value="native" name="languages_level" type="radio"><span>Native</span></label>
              </div>
              @error('add_language.level') <span class="hr-field-error">{{ $message }}</span> @enderror

              @if (isset($add_language['id']))
                <button type="button" class="hr-btn-outline hr-btn-outline--sm hr-add-panel__submit" wire:click='updateLanguage'>Update</button>
              @else
                <button type="button" class="hr-btn-outline hr-btn-outline--sm hr-add-panel__submit" wire:click='addLanguage'>Add</button>
              @endif
            </div>

            <div x-show="!isAddLanguage">
              @if (auth()->user()->Languages->count())
                <div class="hr-chip-list">
                  @foreach (auth()->user()->Languages as $lg)
                    <span class="hr-chip">
                      <strong>{{ Str::ucfirst($lg->name) }}</strong> &middot; {{ Str::ucfirst($lg->level) }}
                      <button type="button" class="hr-chip__edit" wire:click="editLanguage({{ $lg->id }})" wire:loading.attr="disabled" aria-label="Edit {{ $lg->name }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                      </button>
                      <button type="button" class="hr-chip__remove" wire:click="deleteLanguage({{ $lg->id }})" wire:loading.attr="disabled" aria-label="Remove {{ $lg->name }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                      </button>
                    </span>
                  @endforeach
                </div>
              @else
                <p class="hr-chip-empty">No language added</p>
              @endif
            </div>
          </div>

          {{-- Skills --}}
          @if (auth()->user()->account_type === 'seller')
            <div class="hr-detail-card">
              <div class="hr-card-head">
                <h3>Skills</h3>
                <button type="button" class="hr-add-toggle" @click="isAddSkill = !isAddSkill">
                  <span x-show="!isAddSkill">+</span>
                  <span x-show="isAddSkill" x-cloak>&times;</span>
                </button>
              </div>

              <div x-show="isAddSkill" x-cloak class="hr-add-panel">
                <input type="text" wire:model.defer="add_skill.name" id="add_skill.name" placeholder="e.g web developper" class="hr-input">
                @error('add_skill.name') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-radio-group">
                  <label class="hr-radio-pill"><input wire:model.defer="add_skill.experience" value="beginner" id="beginner" name="skill_experience" type="radio" checked><span>Beginner</span></label>
                  <label class="hr-radio-pill"><input wire:model.defer="add_skill.experience" value="intermediate" id="intermediate" name="skill_experience" type="radio"><span>Intermediate</span></label>
                  <label class="hr-radio-pill"><input wire:model.defer="add_skill.experience" value="pro" id="expert" name="skill_experience" type="radio"><span>Expert</span></label>
                </div>
                @error('add_skill.experience') <span class="hr-field-error">{{ $message }}</span> @enderror

                @if (isset($add_skill['id']))
                  <button type="button" class="hr-btn-outline hr-btn-outline--sm hr-add-panel__submit" wire:click='updateSkill'>Update</button>
                @else
                  <button type="button" class="hr-btn-outline hr-btn-outline--sm hr-add-panel__submit" wire:click='addSkill'>Add</button>
                @endif
              </div>

              {{-- list Skills --}}
              <div x-show="!isAddSkill">
                @forelse (auth()->user()->skills as $sk)
                  <div class="hr-chip hr-skill-chip">
                    <div class="hr-skill-chip__row">
                      <span><strong>{{ Str::ucfirst($sk->name) }}</strong> &middot; {{ Str::ucfirst($sk->experience) }}</span>
                      <span style="display:flex;gap:4px;">
                        <button type="button" class="hr-chip__edit" wire:click="editSkill({{ $sk->id }})" wire:loading.attr="disabled" aria-label="Edit {{ $sk->name }}">
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button type="button" class="hr-chip__remove" wire:click="deleteSkill({{ $sk->id }})" wire:loading.attr="disabled" aria-label="Remove {{ $sk->name }}">
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                      </span>
                    </div>
                    <div class="hr-skill-bar">
                      <div class="hr-skill-bar__fill hr-skill-bar__fill--{{$sk->experience=='pro'?'pro':($sk->experience=='intermediate'?'intermediate':'beginner')}}" style="width: {{$sk->experience=='pro'?100:($sk->experience=='intermediate'?66:33)}}%"></div>
                    </div>
                  </div>
                @empty
                  <p class="hr-chip-empty">No skill added</p>
                @endforelse
              </div>
            </div>
          @endif
        </div>

        {{-- seller informations --}}
        <div>
          @if (auth()->user()->account_type === 'seller')
            <div class="hr-profile-main-row">
              {{-- PORTFOLIOS --}}
              <div class="hr-detail-card">
                <div class="hr-card-head">
                  <h3>Portfolio</h3>
                </div>
                <div class="hr-portfolio-grid">
                  @foreach (auth()->user()->projects as $project)
                    @if ($project->status === 'active')
                      <a href="{{ url('projects', $project->slug) }}" target="_blank" class="hr-portfolio-item">
                        <img src="{{src($project->thumbnail)}}" alt="{{ $project->title }}">
                      </a>
                    @endif
                  @endforeach
                  <a href="{{ url('create/project') }}" target="_blank" title="Add project" class="hr-portfolio-add">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  </a>
                </div>
                <a href="{{ url('profile/' . auth()->user()->username . '/portfolio') }}" target="_blank" class="hr-portfolio-view-link">View my portfolio</a>
              </div>

              {{-- Linked accounts --}}
              <div class="hr-detail-card">
                <div class="hr-card-head">
                  <h3>Linked accounts</h3>
                </div>

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-facebook-f" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="facebook_profile" id="facebook_profile" placeholder="Facebook profile">
                </div>
                @error('facebook_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-twitter" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="twitter_profile" placeholder="Twitter profile">
                </div>
                @error('twitter_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-dribbble" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="dribbble_profile" placeholder="Dribbble profile">
                </div>
                @error('dribbble_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-stack-overflow" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="stackoverflow_profile" placeholder="Stack Overflow profile">
                </div>
                @error('stackoverflow_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-github" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="github_profile" placeholder="GitHub profile">
                </div>
                @error('github_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-youtube" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="youtube_profile" placeholder="YouTube profile">
                </div>
                @error('youtube_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-social-row">
                  <span class="hr-social-row__icon"><i class="fab fa-vimeo" aria-hidden="true"></i></span>
                  <input type="text" class="hr-input" wire:model.defer="vimeo_profile" placeholder="Vimeo profile">
                </div>
                @error('vimeo_profile') <span class="hr-field-error">{{ $message }}</span> @enderror

                <div class="hr-onboarding-actions" style="margin-top:4px;">
                  <button type="button" class="hr-btn-primary hr-onboarding-submit" wire:click='updateSocial'>Update</button>
                </div>
              </div>
            </div>
          @endif
        </div>

      </div>
    </div>
  </section>
</div>

@push('scripts')
  {{-- AlpineJs --}}
  <script>
      function TJPlQeqplTFcTQC() {
          return {

              isHeadlineEditing   : false,
              isAddSkill          : false,
              isAddLanguage       : false,
              isDescriptionEditing: false,

              // Edit headline
              toggleEditingHeadline() {
                  this.isHeadlineEditing = !this.isHeadlineEditing;

                  if (this.isHeadlineEditing) {
                      setTimeout(() => {
                          this.$refs.edit_headline.focus();
                      });
                  }
              },

              // Disable headline editing
              disableEditing() {
                  this.isHeadlineEditing = false;
              },

              // Avatar changed
              avatar(event) {
                  var output    = document.getElementById('profile-avatar-preview');
                  output.src    = text.createObjectURL(event.target.files[0]);
                  output.onload = function() {
                      URL.revokeObjectURL(output.src) // free memory
                  }
              },

              // Init
              init() {

                  // Headline updated
                  window.addEventListener('profile-headline-updated',() => {
                      this.disableEditing();
                  });

                  // Edit skill form
                  window.addEventListener('open-skills-edit-form',() => {
                      this.isAddSkill = true;
                  });

                  // Close edit skill form
                  window.addEventListener('close-edit-skill-form',() => {
                      this.isAddSkill = false;
                  });

                  // Edit language form
                  window.addEventListener('open-languages-edit-form',() => {
                      this.isAddLanguage = true;
                  });

                  // Close edit language form
                  window.addEventListener('close-edit-language-form',() => {
                      this.isAddLanguage = false;
                  });

                  // Close description edit form
                  window.addEventListener('close-description-edit-form',() => {
                      this.isDescriptionEditing = false;
                  });

              }

          }
      }
      window.TJPlQeqplTFcTQC = TJPlQeqplTFcTQC();
  </script>

@endpush
