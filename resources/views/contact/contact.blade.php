@extends('layouts.myL')
@section('title','Contact')
@section('main')

<section class="hr-hero" style="padding-bottom:48px;">
  <div class="hr-hero__shapes">
    <div class="hr-shape hr-shape--dots"></div>
    <div class="hr-shape hr-shape--circle-outline"></div>
    <div class="hr-shape hr-shape--rings"></div>
    <div class="hr-shape hr-shape--dots-right"></div>
  </div>
  <div class="auto-container">
    <div class="hr-hero__inner">
      <div class="hr-badge">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/></svg>
        Get In Touch
      </div>
      <h1>Let's Talk About <span class="hr-accent">Everything</span></h1>
      <p class="hr-hero__subtitle">Have a question, a project idea, or just want to say hello? We'd love to hear from you.</p>
    </div>
  </div>
</section>

<section class="hr-section" style="padding-top:0;">
  <div class="auto-container">
    <div class="hr-contact-grid">
      <div class="hr-contact-info">
        <div class="hr-contact-illustration">
          <svg viewBox="0 0 420 340" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="352" cy="286" r="34" fill="var(--hr-primary-light)"/>
            <circle cx="30" cy="70" r="3" fill="var(--hr-primary)" opacity="0.3"/>
            <circle cx="46" cy="56" r="3" fill="var(--hr-primary)" opacity="0.3"/>
            <circle cx="30" cy="42" r="3" fill="var(--hr-primary)" opacity="0.3"/>
            <circle cx="46" cy="86" r="3" fill="var(--hr-primary)" opacity="0.3"/>
            <circle cx="62" cy="70" r="3" fill="var(--hr-primary)" opacity="0.3"/>

            <rect x="40" y="40" width="300" height="224" rx="18" fill="#fff" stroke="var(--hr-border)" stroke-width="2"/>
            <path d="M40 58a18 18 0 0 1 18-18h264a18 18 0 0 1 18 18v10H40Z" fill="var(--hr-primary)"/>
            <circle cx="56" cy="58" r="3.5" fill="#fff" opacity="0.85"/>
            <circle cx="68" cy="58" r="3.5" fill="#fff" opacity="0.6"/>
            <circle cx="80" cy="58" r="3.5" fill="#fff" opacity="0.4"/>

            <circle cx="72" cy="108" r="15" fill="var(--hr-bg-soft)" stroke="var(--hr-border)" stroke-width="2"/>
            <path d="M65 111a7 7 0 0 1 14 0" stroke="var(--hr-primary)" stroke-width="2" stroke-linecap="round"/>
            <circle cx="72" cy="104" r="3.5" fill="var(--hr-primary)"/>
            <rect x="98" y="99" width="76" height="8" rx="4" fill="var(--hr-border)"/>
            <rect x="98" y="112" width="46" height="6" rx="3" fill="#EEF1F8"/>

            <rect x="72" y="140" width="248" height="10" rx="5" fill="var(--hr-bg-soft)"/>
            <rect x="72" y="160" width="212" height="10" rx="5" fill="var(--hr-bg-soft)"/>
            <rect x="72" y="180" width="150" height="10" rx="5" fill="var(--hr-primary-light)"/>

            <rect x="288" y="14" width="98" height="60" rx="18" fill="var(--hr-primary)"/>
            <path d="M300 74l6-16h10z" fill="var(--hr-primary)"/>
            <circle cx="315" cy="44" r="4.5" fill="#fff"/>
            <circle cx="337" cy="44" r="4.5" fill="#fff" opacity="0.75"/>
            <circle cx="359" cy="44" r="4.5" fill="#fff" opacity="0.5"/>

            <circle cx="352" cy="286" r="34" fill="#fff" stroke="var(--hr-border)" stroke-width="2"/>
            <path d="M337 292v-6a15 15 0 0 1 30 0v6" stroke="var(--hr-primary)" stroke-width="3" stroke-linecap="round" fill="none"/>
            <rect x="333" y="290" width="9" height="16" rx="4" fill="var(--hr-primary)"/>
            <rect x="363" y="290" width="9" height="16" rx="4" fill="var(--hr-primary)"/>
            <path d="M342 306v3a7 7 0 0 0 7 7h5" stroke="var(--hr-primary)" stroke-width="3" stroke-linecap="round" fill="none"/>

            <rect x="8" y="220" width="34" height="34" rx="10" fill="var(--hr-bg-soft)" transform="rotate(-8 25 237)"/>
            <circle cx="392" cy="150" r="16" fill="var(--hr-bg-soft)"/>
          </svg>
        </div>

        <div class="hr-contact-item">
          <span class="hr-contact-item__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </span>
          <div>
            <strong>Call us</strong>
            <p>+212 644209739</p>
          </div>
        </div>
        <div class="hr-contact-item">
          <span class="hr-contact-item__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/></svg>
          </span>
          <div>
            <strong>Email us</strong>
            <p>support@madlancer.com</p>
          </div>
        </div>
        <div class="hr-contact-item">
          <span class="hr-contact-item__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </span>
          <div>
            <strong>Visit us</strong>
            <p>FES, Morocco</p>
          </div>
        </div>
      </div>

      <div class="hr-contact-card">
        <h2>Send us a message</h2>
        <p>Fill out the form below and we'll get back to you within 24 hours.</p>

        <form method="get" action="{{route('send')}}" id="contactForm" name="contactForm" class="hr-contact-form">
          <div class="hr-form-group">
            <label for="name">Your name</label>
            <input type="text" class="hr-input" name="name" id="name" required placeholder="John Doe">
          </div>
          <div class="hr-form-group">
            <label for="email">Email</label>
            <input type="email" class="hr-input" name="email" id="email" required placeholder="john@example.com">
          </div>
          <div class="hr-form-group">
            <label for="subject">Subject</label>
            <input type="text" class="hr-input" name="subject" id="subject" required placeholder="How can we help?">
          </div>
          <div class="hr-form-group">
            <label for="message">Message</label>
            <textarea class="hr-input hr-textarea" name="message" id="message" cols="30" rows="6" required placeholder="Write your message..."></textarea>
          </div>

          <button type="submit" class="hr-btn-primary">
            Send Message
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
          <span class="submitting"></span>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
