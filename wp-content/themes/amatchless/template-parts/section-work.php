<!-- ============ PORTFOLIO / WORK ============ -->
<?php
// [name, site, services, panel colour, word colour, wordmark HTML, word size, extra classes, badges HTML]
$work = [
    ['MD Biocoals', 'https://www.mdbiocoals.com', 'CUSTOM CRM · AUTOMATION · MARKETING', '#0F5A3A', '#3DEBB0', 'MD<br>Biocoals', 46, '',
        '<span class="wbadge tilt" style="background:#FFE14D">₹100 CR · SINCE 1999</span>'],
    ['Isola by SK', 'https://isolabysk.com', 'WEB DEVELOPMENT · SOCIAL MEDIA', '#FF7A1A', '#0E0B1F', 'Isola', 68, ' italic',
        '<span class="wbadge tilt" style="background:#FFFFFF">575K CREATOR</span>'],
    ['AleuCo Beauty Studio', 'https://aleuco.com', 'SEO · AEO/GEO · BRANDING', '#FFC2DD', '#B0125B', 'AleuCo', 62, '',
        '<span class="wbadge tilt" style="background:#0E0B1F;color:#FFFFFF">BEAUTY ON DEMAND</span>'],
    ["Bailey's Blossoms", 'https://www.baileysblossoms.com', 'META ADS · 4× ROAS', '#FFE14D', '#0E0B1F', 'Bailey\'s<br>Blossoms', 46, '',
        '<span class="wbadge wiggle" style="background:#FF4F9A">★ SHARK TANK</span><span class="wcoin">4×</span>'],
    ['Moment', 'https://drinkmoment.com', 'SEO · BRANDING · ADS', '#5B2EFF', '#FFFFFF', 'moment', 66, '',
        '<span class="wbadge wiggle" style="background:#FF4F9A">★ SHARK TANK</span>'],
    ['Haliburton Forest', 'https://www.haliburtonforest.com', 'WEB DEVELOPMENT · BOOKING SYSTEM', '#3DEBB0', '#0E0B1F', 'Haliburton<br>Forest', 44, '',
        '<span class="wbadge tilt" style="background:#FFFFFF">BOOKING SYSTEM</span>'],
];
?>
<section class="sec" id="work">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">SELECTED WORK</span>
        <h2 class="h2">Projects we're proud to put our name on.</h2>
      </div>
      <?php if (!is_page('work')) : ?>
      <a class="btn btn-white btn-lg" href="<?php echo esc_url(amatchless_page_url('work')); ?>">See all case studies →</a>
      <?php endif; ?>
    </div>

    <div class="work-grid">
      <?php foreach ($work as [$name, $url, $svc, $bg, $fg, $word, $size, $cls, $badges]) : ?>
      <a class="work reveal" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
        <div class="work-panel" style="background:<?php echo esc_attr($bg); ?>">
          <span class="work-word<?php echo esc_attr($cls); ?>" style="color:<?php echo esc_attr($fg); ?>;font-size:<?php echo (int) $size; ?>px"><?php echo wp_kses($word, ['br' => []]); ?></span>
          <?php echo $badges; // static markup above ?>
        </div>
        <div class="work-info">
          <div><span class="work-name"><?php echo esc_html($name); ?></span><span class="work-svc"><?php echo esc_html($svc); ?></span></div>
          <span class="work-arrow" aria-hidden="true">↗</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
