<!-- ============ CTA / CONTACT ============ -->
<section class="band band-line" id="contact">
  <div class="wrap">
    <div class="cta up">
      <span class="eyebrow" style="justify-content:center">Let's talk</span>
      <h2 style="margin-top:20px">Let's make your business <span class="flame">matchless.</span></h2>
      <p>Tell us what is slowing your business down and where you want to be in twelve months. We'll show you how to run leaner and grow faster.</p>
      <div class="cta-actions">
        <a href="#book" class="btn btn-primary" id="ctaBook">Book a discovery call <span class="arw" aria-hidden="true">↗</span></a>
        <a href="#services" class="btn btn-ghost">See what we do</a>
      </div>
      <div class="email-row">
        <span>Prefer email?</span>
        <span class="em" id="email"><?php echo esc_html(AMATCHLESS_EMAIL); ?></span>
        <button class="copy" id="copyEmail" type="button">Copy</button>
      </div>
    </div>

    <div class="lead up" id="book">
      <div class="lead-info">
        <span class="eyebrow">Book a discovery call</span>
        <h3>30 minutes. Zero commitment. Tell us what is holding your business back.</h3>
        <p class="lede">Tell us about your business and we'll reply within 24 hours with honest thoughts — no sales pitch, no pressure.</p>
        <div class="lead-contacts">
          <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><span class="k">Email</span><span class="v"><?php echo esc_html(AMATCHLESS_EMAIL); ?></span></a>
          <a href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_E164); ?>"><span class="k">Call</span><span class="v"><?php echo esc_html(AMATCHLESS_PHONE); ?></span></a>
          <a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener"><span class="k">WhatsApp</span><span class="v">Chat with the team ↗</span></a>
          <a href="https://www.instagram.com/amatchless_/" target="_blank" rel="noopener" data-social="Instagram"><span class="k">Instagram</span><span class="v">@amatchless_ ↗</span></a>
        </div>
      </div>
      <div class="lead-form">
        <form id="leadForm" novalidate>
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
          <div class="form-row one">
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
          </div>
          <div class="form-grp">
            <label class="form-lbl" for="f-msg">What's slowing your business down? *</label>
            <textarea class="form-ctrl" id="f-msg" name="message" placeholder="What's not working today, and where do you want to be in twelve months?" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary form-submit">Book a discovery call <span class="arw" aria-hidden="true">↗</span></button>
          <p class="form-note">Confidential. No spam. We reply within 24 hours.</p>
          <ol class="next-steps" aria-label="What happens next">
            <li><b>1</b> We reply within 24 hours</li>
            <li><b>2</b> A 30-minute discovery call</li>
            <li><b>3</b> You get a clear plan</li>
          </ol>
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
