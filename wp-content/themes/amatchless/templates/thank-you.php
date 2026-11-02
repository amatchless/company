<?php
/* /thank-you/ after an ad landing page form. The Lead event is pushed by assets/js/landing.js
   only when the visitor arrives here from a form submission (it reads sessionStorage 'amx-lead'). */
get_header('lp');
?>

<section class="lp-hero lp-ty" id="thank-you">
  <div class="lp-hero-in">
    <div class="tick lp-ty-tick" aria-hidden="true">✓</div>
    <h1 class="lp-h1">Thank you. We'll call you within 2 working hours.</h1>
    <p class="lp-sub">Want to skip the wait? Pick a time for a call below, or message us on WhatsApp.</p>
    <div class="btn-row">
      <a class="btn btn-pink btn-lg" href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">WhatsApp us on +91 85869 29882</a>
    </div>
  </div>
</section>

<section class="lp-sec lp-cal-sec" id="book-a-call">
  <div class="lp-in">
    <h2 class="lp-h2">Book a call</h2>
    <div class="lp-cal" id="lpCalendly" data-url="https://calendly.com/amatchless?hide_gdpr_banner=1&amp;primary_color=5b2eff">
      <p class="lp-cal-fallback">Loading the calendar… If it doesn't appear, <a href="https://calendly.com/amatchless" target="_blank" rel="noopener">open Calendly in a new tab</a>.</p>
    </div>
  </div>
</section>

<?php get_footer('lp'); ?>
