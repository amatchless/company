<!-- ============ BLOG: WHY TRUST US ============ -->
<?php
// Client work behind the playbooks: [client, what we did, image, srcset].
$proof = [
    ['Moment', 'SEO · Branding · Ads', 'hero-moment-780.webp', 'hero-moment-400.webp 400w, hero-moment-780.webp 780w', 'Moment drink can held up against a blue sky'],
    ["Bailey's Blossoms", 'Meta ads · 4× return on ad spend', 'hero-baileys-480.webp', 'hero-baileys-320.webp 320w, hero-baileys-480.webp 480w', "Bailey's Blossoms bouquet"],
    ['Haliburton Forest', 'Website · Booking system', 'hero-haliburton-720.webp', 'hero-haliburton-360.webp 360w, hero-haliburton-720.webp 720w', 'Haliburton Forest landscape'],
];
$stats = [
    ['4×', 'Return on ad spend delivered', '#FF4F9A'],
    ['3',  'Countries served: India, US & Canada', '#5B2EFF'],
    ['08', 'Core services under one roof', '#0E0B1F'],
];
?>
<section class="sec blog-trust" id="trust">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">WHY TRUST THESE PLAYBOOKS</span>
        <h2 class="h2">Written by the team behind real <span class="hl-purple">results.</span></h2>
      </div>
      <a class="btn btn-white btn-lg" href="<?php echo esc_url(amatchless_page_url('work')); ?>">See our work →</a>
    </div>
    <div class="proof-grid">
      <?php foreach ($proof as [$name, $what, $img, $srcset, $alt]) : ?>
      <figure class="proof reveal">
        <img src="<?php echo esc_url(amatchless_img($img)); ?>" srcset="<?php echo esc_attr(preg_replace_callback('/(\S+\.webp)/', fn($m) => amatchless_img($m[1]), $srcset)); ?>" sizes="(min-width: 1100px) 384px, (min-width: 700px) 33vw, 100vw" alt="<?php echo esc_attr($alt); ?>" loading="lazy" decoding="async">
        <figcaption><b><?php echo esc_html($name); ?></b><span><?php echo esc_html($what); ?></span></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <div class="proof-stats">
      <?php foreach ($stats as [$v, $l, $c]) : ?>
      <div class="proof-stat reveal"><span class="stat-v" style="color:<?php echo esc_attr($c); ?>"><?php echo esc_html($v); ?></span><span><?php echo esc_html($l); ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
