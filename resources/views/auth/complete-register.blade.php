@extends('layouts.myL')
@section('title',"Register")
@section('main')

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
        Almost there
      </div>
      <h1>Welcome to <span class="hr-accent">MadLancer</span></h1>
      <p class="hr-hero__subtitle">Let's complete your profile so buyers and sellers can get to know you.</p>

      <div class="hr-onboarding-card">
        @if(session('error'))
          <div class="hr-alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{ session('error') }}
          </div>
        @endif

        <form class="form bravo-form-register" method="post">
          <div class="hr-form-group">
            <label>Country</label>
            <select name="country" class="hr-input">
              @foreach ($countries as $c)
                <option value="{{$c->id}}">{{$c->name}}</option>
              @endforeach
            </select>
            @error('country') <span class="hr-field-error">{{ $message }}</span> @enderror
          </div>

          <div class="hr-form-group">
            <label>Headline</label>
            <input type="text" class="hr-input" name="headline" autocomplete="off" placeholder="e.g. Full-Stack Developer">
            @error('headline') <span class="hr-field-error">{{ $message }}</span> @enderror
          </div>

          <div class="hr-form-group">
            <label>Description</label>
            <textarea name="description" class="hr-input hr-textarea" placeholder="Tell us about yourself..."></textarea>
            @error('description') <span class="hr-field-error">{{ $message }}</span> @enderror
          </div>

          <button class="hr-btn-primary hr-cart-checkout" wire:click.prevent='store()' wire:loading.attr="disabled" type="button">
            <span wire:loading.remove>Next Step</span>
            <svg wire:loading.remove width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            <span wire:loading class="hr-spinner" style="width:16px;height:16px;border-width:2px;"></span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

@endsection
