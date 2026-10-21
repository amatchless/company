<!-- ============ FAQ ============ -->
<section class="sec" id="faq">
  <div class="sec-in faq-grid">
    <div class="sec-head reveal">
      <span class="label" style="color:#5B2EFF">QUESTIONS</span>
      <h2 class="h2">What most businesses ask before they get in touch.</h2>
      <p class="sec-aside">Still unsure? Send us a note and we'll answer it on the call.</p>
    </div>
    <div class="faq-list reveal">
      <?php foreach (amatchless_faqs() as [$q, $a]) : ?>
      <details class="faq-item"><summary><?php echo esc_html($q); ?></summary><p><?php echo esc_html($a); ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
