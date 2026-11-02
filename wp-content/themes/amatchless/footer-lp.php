<?php
/* Footer for the ad landing pages and /thank-you/: address, phone, email, Privacy and Terms. */
$privacy = amatchless_privacy_url();
?>
</main>

<footer class="lp-foot">
  <div class="lp-foot-in">
    <p class="lp-foot-mark" aria-hidden="true">amatchless<span>.</span></p>
    <address class="lp-foot-contact">
      <?php if (AMATCHLESS_SHOW_ADDRESS) : ?><span><?php echo esc_html(AMATCHLESS_ADDRESS); ?></span><?php endif; ?>
      <a href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_TEL); ?>"><?php echo esc_html(AMATCHLESS_PHONE); ?></a>
      <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><?php echo esc_html(AMATCHLESS_EMAIL); ?></a>
    </address>
    <div class="lp-foot-bot">
      <span>&copy; <?php echo esc_html(date('Y')); ?> Amatchless Private Limited</span>
      <span class="lp-foot-links">
        <a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a>
        <a href="<?php echo esc_url(amatchless_terms_url()); ?>">Terms</a>
        <button type="button" class="foot-cookie" data-cookie-open>Cookie settings</button>
      </span>
    </div>
  </div>
</footer>

<!-- Sticky contact bar on phones -->
<div class="lp-sticky" role="complementary" aria-label="Contact us">
  <a class="btn btn-white" href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_TEL); ?>">Call</a>
  <a class="btn lp-sticky-wa" href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.05 21.785h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>WhatsApp us</a>
</div>

<div class="cookie" id="cookieBanner" role="region" aria-label="Cookie consent" hidden>
  <p class="cookie-title">Cookies, but only if you're okay with it.</p>
  <p class="cookie-text">We use analytics and ad cookies to see what's working on this site and to measure our campaigns. None are set until you say yes. <a href="<?php echo esc_url($privacy); ?>">Read our privacy policy</a>.</p>
  <div class="cookie-btns">
    <button type="button" class="btn btn-yellow" data-cookie="granted">Accept all</button>
    <button type="button" class="btn btn-white" data-cookie="denied">Decline</button>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
