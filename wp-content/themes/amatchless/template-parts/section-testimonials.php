<!-- ============ TESTIMONIALS ============ -->
<?php
// Quotes live in inc/testimonials.php. Visitors see approved ones only; nothing renders until one is approved.
$tms = amatchless_visible_testimonials();
if (!$tms) return;
$drafts = count(array_filter($tms, function ($t) { return empty($t['approved']); }));
$star   = '<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M12 1.8l3.1 6.6 7.2.9-5.3 5 1.4 7.1L12 17.9l-6.4 3.5L7 14.3l-5.3-5 7.2-.9z"/></svg>';
?>
<section class="sec sec-tm" id="testimonials">
  <svg class="float hide-sm tm-spark" aria-hidden="true" width="64" height="64" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FFE14D" stroke="#0E0B1F" stroke-width="1.6"/></svg>
  <div class="sec-in">
    <?php if ($drafts) : ?>
    <p class="tm-notice" role="note"><b>Only admins can see this.</b> <?php echo (int) $drafts; ?> testimonial<?php echo $drafts > 1 ? 's are drafts' : ' is a draft'; ?> waiting for client sign-off. Visitors see approved ones only (set <code>'approved' => true</code> in <code>inc/testimonials.php</code>).</p>
    <?php endif; ?>

    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">WHAT CLIENTS SAY</span>
        <h2 class="h2">Don't take our word for it. <span class="mark-yellow">Take theirs.</span></h2>
      </div>
      <p class="sec-aside">Founders and teams we build and grow with, in India, the US and Canada.</p>
    </div>

    <div class="tm-grid">
      <?php foreach ($tms as $i => $t) :
          $who  = $t['name'] !== '' ? $t['name'] : $t['role'] . ', ' . $t['company'];
          $role = $t['name'] !== '' ? $t['role'] . ', ' . $t['company'] : $t['services'];
          $img  = get_template_directory_uri() . '/assets/img/clients/' . $t['slug'] . '.svg?ver=' . AMATCHLESS_VERSION;
          $cls  = 'tm-card reveal' . (!empty($t['featured']) ? ' tm-feature' : '') . (empty($t['approved']) ? ' tm-draft' : '');
      ?>
      <figure class="<?php echo esc_attr($cls); ?>" style="--c:<?php echo esc_attr($t['bg']); ?>">
        <?php if (empty($t['approved'])) : ?><span class="tm-draft-tag">DRAFT · NEEDS CLIENT OK</span><?php endif; ?>
        <div class="tm-top">
          <span class="tm-stars" role="img" aria-label="<?php echo esc_attr((int) $t['rating'] . ' out of 5 stars'); ?>"><?php echo str_repeat($star, max(0, min(5, (int) $t['rating']))); // static SVG ?></span>
          <span class="tm-mark" aria-hidden="true">”</span>
        </div>
        <blockquote class="tm-quote"><p><?php echo amatchless_testimonial_quote($t); // escaped in the helper ?></p></blockquote>
        <figcaption class="tm-who">
          <span class="tm-av"><img src="<?php echo esc_url($img); ?>" width="64" height="60" loading="lazy" decoding="async" alt=""></span>
          <span class="tm-id"><b><?php echo esc_html($who); ?></b><span><?php echo esc_html($role); ?></span></span>
          <a class="tm-link" href="<?php echo esc_url(amatchless_case_url($t['slug'])); ?>" aria-label="<?php echo esc_attr('Read the ' . $t['company'] . ' story'); ?>">→</a>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
