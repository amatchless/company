</main>

<?php $blog_url = amatchless_blog_url(); ?>
<footer>
  <div class="wrap">
    <div class="foot-top">
      <div class="foot-brand">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Amatchless home">
          <img class="mark" src="<?php echo esc_url(amatchless_img('logo.png')); ?>" alt="" width="30" height="23">
          <span><b>Amatchless</b></span>
        </a>
        <p>Your one-stop partner for software, AI and marketing. We learn your business, then help it run more efficiently and grow.</p>
      </div>
      <div class="foot-col">
        <h5>Services</h5>
        <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Business strategy</a>
        <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Custom software</a>
        <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">SEO &amp; digital marketing</a>
        <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Influencer &amp; content</a>
        <a href="<?php echo esc_url(amatchless_page_url('ai-automation')); ?>">AI Automation</a>
      </div>
      <div class="foot-col">
        <h5>Company</h5>
        <a href="<?php echo esc_url(amatchless_page_url('about')); ?>">About us</a>
        <a href="<?php echo esc_url(amatchless_page_url('work')); ?>">Our work</a>
        <a href="<?php echo esc_url(amatchless_page_url('work')); ?>">Case studies</a>
        <a href="<?php echo esc_url($blog_url ?: amatchless_anchor('blog')); ?>">Blog</a>
        <a href="<?php echo esc_url(amatchless_anchor('contact')); ?>">Contact</a>
      </div>
      <div class="foot-col">
        <h5>Connect</h5>
        <a href="https://www.instagram.com/amatchless" target="_blank" rel="noopener" data-social="Instagram">Instagram</a>
        <a href="https://www.linkedin.com/company/amatchless" target="_blank" rel="noopener" data-social="LinkedIn">LinkedIn</a>
        <a href="https://www.youtube.com/@amatchless" target="_blank" rel="noopener" data-social="YouTube">YouTube</a>
        <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><?php echo esc_html(AMATCHLESS_EMAIL); ?></a>
      </div>
    </div>
    <div class="foot-bot">
      <span>&copy; <?php echo esc_html(date('Y')); ?> Amatchless. All rights reserved.</span>
      <?php $privacy = get_privacy_policy_url(); if ($privacy) : ?>
      <span class="foot-legal"><a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a></span>
      <?php endif; ?>
      <span>Gurugram, India — working worldwide</span>
    </div>
  </div>
</footer>

<a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" class="wa-float" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
