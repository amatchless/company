<!-- Book a discovery call form (posts to amatchless_contact_submit via assets/js/site.js) -->
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
