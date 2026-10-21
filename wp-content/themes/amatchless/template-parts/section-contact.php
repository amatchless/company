<!-- ============ CTA / CONTACT ============ -->
<section class="cta-sec" id="contact">
  <div class="cta">
    <div class="blob cta-blob" aria-hidden="true"></div>
    <svg class="float hide-sm cta-star" aria-hidden="true" width="110" height="110" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FFE14D"/></svg>

    <div class="cta-grid">
      <div class="cta-copy">
        <span class="label" style="color:#FFE14D">LET'S TALK</span>
        <h2 class="h2 h2-xl reveal">Let's make your business <span style="color:#FFE14D">matchless.</span></h2>
        <p class="cta-lede">Tell us what's slowing you down and where you want to be in twelve months. 30 minutes. Zero commitment. Reply within 24 hours.</p>
        <div class="btn-row">
          <a class="btn btn-yellow btn-lg" href="#book" id="ctaBook">Book a discovery call <span aria-hidden="true">↗</span></a>
          <a class="btn btn-outline-white btn-lg" href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><?php echo esc_html(AMATCHLESS_EMAIL); ?></a>
        </div>
        <ul class="cta-contacts">
          <li><a href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_E164); ?>">Call <?php echo esc_html(AMATCHLESS_PHONE); ?></a></li>
          <li><a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">WhatsApp us ↗</a></li>
          <li><a href="https://www.instagram.com/amatchless_/" target="_blank" rel="noopener" data-social="Instagram">@amatchless_ ↗</a></li>
        </ul>
      </div>

      <div class="lead-card" id="book">
        <form id="leadForm" novalidate>
          <p class="lead-title">Book a discovery call</p>
          <div class="form-row">
            <div class="form-grp">
              <label class="form-lbl" for="f-name">Your name *</label>
              <input class="form-ctrl" type="text" id="f-name" name="name" placeholder="Full name" required autocomplete="name">
            </div>
            <div class="form-grp">
              <label class="form-lbl" for="f-co">Business name</label>
              <input class="form-ctrl" type="text" id="f-co" name="company" placeholder="Company / brand" autocomplete="organization">
            </div>
          </div>
          <div class="form-row">
            <div class="form-grp">
              <label class="form-lbl" for="f-email">Email *</label>
              <input class="form-ctrl" type="email" id="f-email" name="email" placeholder="you@company.com" required autocomplete="email">
            </div>
            <div class="form-grp">
              <label class="form-lbl" for="f-phone">Phone</label>
              <input class="form-ctrl" type="tel" id="f-phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel">
            </div>
          </div>
          <div class="form-grp">
            <label class="form-lbl" for="f-service">Service</label>
            <select class="form-ctrl" id="f-service" name="service">
              <option value="">Select a service</option>
              <option>Business discovery &amp; strategy</option>
              <option>Custom software &amp; web</option>
              <option>AI solutions</option>
              <option>Process automation</option>
              <option>SEO</option>
              <option>Digital marketing &amp; ads</option>
              <option>Influencer marketing</option>
              <option>Content, social &amp; branding</option>
              <option>Not sure yet — help me decide</option>
            </select>
          </div>
          <div class="form-grp">
            <label class="form-lbl" for="f-msg">What's slowing your business down? *</label>
            <textarea class="form-ctrl" id="f-msg" name="message" placeholder="What's not working today, and where do you want to be in twelve months?" required></textarea>
          </div>
          <button type="submit" class="btn btn-pink btn-lg form-submit">Send — we reply within 24 hours <span aria-hidden="true">↗</span></button>
          <p class="form-note">Confidential. No spam. A 30-minute call, then a clear plan.</p>
        </form>
        <div class="form-success" id="formOk" tabindex="-1" hidden>
          <div class="tick" aria-hidden="true">✓</div>
          <h3>You're all set.</h3>
          <p>We've got your details. Expect to hear from the Amatchless team within 24 hours. In a hurry? <a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">Message us on WhatsApp</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
