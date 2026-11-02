<?php
/* Ad landing page template (/lp/influencer-marketing/, /lp/seo-check/). Content: amatchless_landing_pages() in inc/landing.php. */
$slug = amatchless_current_lp();
$lp   = amatchless_landing_pages()[$slug];
// Brand names already shown publicly on the site (/work/). Set as greyscale wordmarks: the site has no logo files
// for them, and the client illustrations are cartoons, which these pages must not use.
$logos = ['Isola', 'AleuCo', "Bailey's Blossoms", 'Moment', 'Haliburton Forest'];
$colors = ['#FFE14D', '#3DEBB0', '#FF4F9A', '#5B2EFF'];
get_header('lp');
?>

<!-- ============ HERO ============ -->
<section class="lp-hero" id="hero">
  <div class="lp-hero-in">
    <span class="pill-dark"><span class="pulse-dot" aria-hidden="true"></span><?php echo esc_html(strtoupper($lp['service'])); ?> · DELHI NCR</span>
    <h1 class="lp-h1"><?php echo esc_html($lp['h1']); ?></h1>
    <p class="lp-sub"><?php echo esc_html($lp['sub']); ?></p>
    <div class="btn-row">
      <a class="btn btn-pink btn-lg" href="#form" data-lp-cta><?php echo esc_html($lp['cta']); ?> <span aria-hidden="true">↓</span></a>
      <a class="btn btn-white btn-lg" href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">WhatsApp us</a>
    </div>
    <p class="lp-note"><?php echo esc_html($lp['note']); ?></p>
  </div>
  <svg class="lp-hero-star" aria-hidden="true" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FFE14D" stroke="#0E0B1F" stroke-width="1.2"/></svg>
</section>

<!-- ============ LOGOS ============ -->
<section class="lp-logos" aria-label="Brands we have worked with">
  <p class="label">Brands we work with</p>
  <ul class="lp-logo-row">
    <?php foreach ($logos as $i => $name) : ?>
    <li class="lp-logo lp-logo-<?php echo (int) $i; ?>"><?php echo esc_html($name); ?></li>
    <?php endforeach; ?>
  </ul>
</section>

<!-- ============ PROBLEM ============ -->
<section class="lp-sec" id="problem">
  <div class="lp-in">
    <h2 class="lp-h2"><?php echo esc_html($lp['problem_h']); ?></h2>
    <div class="lp-grid lp-grid-3">
      <?php foreach ($lp['problems'] as [$t, $d]) : ?>
      <article class="lp-card-item lp-problem"><span class="lp-x" aria-hidden="true">✕</span><h3><?php echo esc_html($t); ?></h3><p><?php echo esc_html($d); ?></p></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ WHAT YOU GET ============ -->
<section class="lp-sec lp-sec-purple" id="offer">
  <div class="lp-in">
    <h2 class="lp-h2"><?php echo esc_html($lp['get_h']); ?></h2>
    <div class="lp-grid lp-grid-4">
      <?php foreach ($lp['gets'] as $i => [$t, $d]) : ?>
      <article class="lp-card-item lp-get"><span class="lp-dot" style="background:<?php echo esc_attr($colors[$i % 4]); ?>" aria-hidden="true">✓</span><h3><?php echo esc_html($t); ?></h3><p><?php echo esc_html($d); ?></p></article>
      <?php endforeach; ?>
    </div>
    <a class="btn btn-yellow btn-lg lp-mid-cta" href="#form" data-lp-cta><?php echo esc_html($lp['cta']); ?> <span aria-hidden="true">↓</span></a>
  </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="lp-sec" id="how">
  <div class="lp-in">
    <h2 class="lp-h2"><?php echo esc_html($lp['steps_h']); ?></h2>
    <ol class="lp-steps">
      <?php foreach ($lp['steps'] as $i => [$t, $d]) : ?>
      <li><span class="lp-num" style="background:<?php echo esc_attr($colors[$i % 4]); ?>;<?php echo $i === 3 ? 'color:#fff' : ''; ?>"><?php echo $i + 1; ?></span><div><h3><?php echo esc_html($t); ?></h3><p><?php echo esc_html($d); ?></p></div></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ============ WHY AMATCHLESS + FORM ============ -->
<section class="lp-sec lp-sec-yellow" id="form">
  <div class="lp-in lp-form-grid">
    <div class="lp-why">
      <h2 class="lp-h2">Why Amatchless</h2>
      <ul class="lp-why-list">
        <?php foreach ($lp['why'] as [$t, $d]) : ?>
        <li><span class="lp-tick" aria-hidden="true">✓</span><div><b><?php echo esc_html($t); ?></b><p><?php echo esc_html($d); ?></p></div></li>
        <?php endforeach; ?>
      </ul>
      <p class="lp-why-alt">Prefer to talk? <a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">WhatsApp us</a> or call <a href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_TEL); ?>"><?php echo esc_html(AMATCHLESS_PHONE); ?></a>.</p>
    </div>
    <?php get_template_part('template-parts/lp-form', null, ['slug' => $slug, 'lp' => $lp]); ?>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="lp-sec" id="faq">
  <div class="lp-in lp-faq">
    <h2 class="lp-h2">Questions</h2>
    <div class="faq-list">
      <?php foreach ($lp['faqs'] as [$q, $a]) : ?>
      <details class="faq-item"><summary><?php echo esc_html($q); ?></summary><p><?php echo esc_html($a); ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_footer('lp'); ?>
