<footer class="main-footer style_1">
    <div class="auto-container">
      <div class="widgets-section wow fadeInUp">
        <div class="row">
          <div class="big-column col-xl-4 col-lg-3 col-md-12">
            <div class="footer-column about-widget">
              <h4 class="widget-title" style="margin-bottom:10px;">MadLancer</h4>
              <p style="color:var(--hr-body);font-size:14.5px;line-height:1.6;max-width:280px;">
                MadLancer is the world's work marketplace connecting businesses with independent talent.
              </p>
              <div class="hr-footer-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="big-column col-xl-8 col-lg-9 col-md-12">
            <div class="row">
              <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                <div class="footer-widget links-widget">
                  <h4 class="widget-title">For Buyer</h4>
                  <div class="widget-content">
                    <ul class="list m-2">
                      <li><a href="{{ url('category/all') }}">Browse Categories</a></li>
                      <li><a href="{{ url('/') }}#how-it-works">How It Works</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                <div class="footer-widget links-widget">
                  <h4 class="widget-title">For Seller</h4>
                  <div class="widget-content">
                    <ul class="list m-2">
                      <li><a href="{{ url('seller/home') }}">Seller Dashboard</a></li>
                      <li><a href="{{ url('/') }}#how-it-works">How It Works</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                <div class="footer-widget links-widget">
                  <h4 class="widget-title">About Us</h4>
                  <div class="widget-content">
                    <ul class="list m-2">
                      <li><a href="{{url('/contact')}}">Contact</a></li>
                      @if ($termsPage)
                        <li><a href="{{ route('page', $termsPage->slug) }}">Terms &amp; Conditions</a></li>
                      @endif
                      @if ($privacyPage)
                        <li><a href="{{ route('page', $privacyPage->slug) }}">Privacy Policy</a></li>
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
              <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                <div class="footer-widget links-widget">
                  <h4 class="widget-title">Contact Us</h4>
                  <div class="widget-content">
                    <ul class="hr-footer-contact">
                      <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        +212 644209739
                      </li>
                      <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"/><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/></svg>
                        support@madlancer.com
                      </li>
                      <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        FES, Morocco
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="auto-container">
        <div class="outer-box">
          <div class="copyright-text">
            <p>
              © 2023 <a href="{{ url('/') }}">MadLancer</a>. All Right
              Reserved.
            </p>
          </div>
          <div class="hr-footer-payments">
            <span class="hr-pay-badge" style="background:#1A1F71;">VISA</span>
            <span class="hr-pay-badge" style="background:#003087;">PayPal</span>
            <span class="hr-pay-badge hr-pay-badge--mc" aria-label="MasterCard">
              <span class="hr-mc-circle hr-mc-circle--red"></span>
              <span class="hr-mc-circle hr-mc-circle--yellow"></span>
            </span>
          </div>
        </div>
      </div>
    </div>
</footer>
