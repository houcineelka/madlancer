@section('title',"Register")

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
      <h1>{!! $title !!}</h1>
      <p class="hr-hero__subtitle">{{ $text }}</p>

      <div class="hr-onboarding-card">
        <button id="btn02" wire:click='nextStep' style="display: none"></button>
        <button id="btn01" wire:click='back' style="display: none"></button>

        @if ($step==1)
          <livewire:auth.complete-register-step1>
        @else
          <livewire:auth.complete-register-step2>
        @endif
      </div>
    </div>
  </div>
</section>
