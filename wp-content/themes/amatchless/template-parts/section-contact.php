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
          <li><a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">WhatsApp us ↗</a></li>
          <li><a href="https://www.instagram.com/amatchless_/" target="_blank" rel="noopener" data-social="Instagram">@amatchless_ ↗</a></li>
        </ul>
      </div>

      <?php get_template_part('template-parts/lead-form'); ?>
    </div>
  </div>
</section>
