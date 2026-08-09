<section class="hr-section" style="padding-top:0;">
    <div class="auto-container">
      <div class="hr-newsletter wow fadeInUp">
        <div class="hr-newsletter__illustration">
          <svg width="130" height="110" viewBox="0 0 130 110" fill="none">
            <circle cx="30" cy="18" r="3" fill="#C9D7FB"/>
            <circle cx="14" cy="34" r="2" fill="#C9D7FB"/>
            <circle cx="42" cy="8" r="2" fill="#C9D7FB"/>
            <path d="M70 6l32 10-13 4 3 13z" fill="#BFD2FF"/>
            <path d="M70 6L54 34l16-10z" fill="var(--hr-primary)"/>
            <path d="M70 6l-16 28 22 6z" fill="#4A78EA"/>
            <rect x="14" y="46" width="90" height="58" rx="10" fill="#fff" stroke="#DCE7FF" stroke-width="2"/>
            <path d="M14 52a6 6 0 0 1 6-6h78a6 6 0 0 1 6 6L59 84 14 52z" fill="#EAF0FF"/>
            <path d="M14 52l45 32 45-32" stroke="var(--hr-primary)" stroke-width="2" fill="none" stroke-linejoin="round"/>
            <circle cx="100" cy="90" r="16" fill="var(--hr-primary)" stroke="#fff" stroke-width="4"/>
            <path d="M93 90l5 5 9-10" stroke="#fff" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="hr-newsletter__text">
          <h2>Subscribe to our Newsletter</h2>
          <p>Get the latest updates and offers delivered to your inbox.</p>
        </div>
        <form method="get" class="hr-newsletter__form">
          <div class="hr-newsletter__form-row">
            <input type="email" wire:model="email" name="email" placeholder="your email here">
            <button wire:click.prevent="news()" type="button">Subscribe</button>
          </div>
          <span class="hr-newsletter__hint">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
            No spam. Unsubscribe anytime.
          </span>
          @error('email')
            <span class="hr-newsletter__hint" style="color:#DC2626;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>
          @enderror
        </form>
      </div>
    </div>
  </section>