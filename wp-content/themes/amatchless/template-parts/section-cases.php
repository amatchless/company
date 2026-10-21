<!-- ============ CASE STUDIES ============ -->
<?php
// [anchor, panel colour, word colour, wordmark, badge HTML, label, title, story HTML, metrics, site]
$cases = [
    ['isola', '#FF7A1A', '#0E0B1F', '<i>Isola</i>', '<span class="wbadge tilt" style="background:#FFFFFF">575K CREATOR</span>',
        'CREATOR BRAND · E-COMMERCE', 'Isola — a resort-wear label, built end to end',
        "For influencer Saanya Khatter, who has 575K followers on Instagram, we designed and developed <strong>Isola</strong>, a luxury resort-wear and swimwear store — “cut for the water, worn to dinner” — and we run the brand's social media day to day. From storefront to feed, one team turned a 575K-strong audience into a premium direct-to-consumer label.",
        [['Web', 'E-commerce store, designed &amp; built'], ['Social', 'Ongoing social media management'], ['DTC', 'Full brand launch, India-wide']],
        'https://isolabysk.com'],
    ['aleuco', '#FFC2DD', '#B0125B', 'AleuCo', '<span class="wbadge tilt" style="background:#0E0B1F;color:#FFFFFF">BEAUTY ON DEMAND</span>',
        'BEAUTY · US MARKET', 'AleuCo — getting a beauty brand found, everywhere',
        "<strong>AleuCo</strong> is a luxury mobile hair-and-makeup studio bringing services straight to clients' doors across the US. We're sharpening the brand and building its visibility — optimising for classic search (SEO) and for the AI answers and local results buyers now rely on (AEO &amp; GEO), so the right clients find AleuCo first.",
        [['SEO', 'Search visibility &amp; local reach'], ['AEO/GEO', 'Found in AI &amp; map answers'], ['Brand', 'Positioning &amp; identity']],
        'https://aleuco.com'],
    ['baileys', '#FFE14D', '#0E0B1F', "Bailey's<br>Blossoms", '<span class="wbadge wiggle" style="background:#FF4F9A">★ SHARK TANK</span><span class="wcoin">4×</span>',
        'E-COMMERCE · KIDS &amp; FAMILY', "Bailey's Blossoms — 4× return from Meta ads",
        "<strong>Bailey's Blossoms</strong> is a much-loved boutique for girls' and “Mommy &amp; Me” clothing, trusted by over a million moms and featured on <em>Shark Tank</em>. We run their Meta (Facebook &amp; Instagram) advertising — building the creative and campaigns that turn ad spend into profitable, repeatable sales.",
        [['4×', 'Return on ad spend'], ['Meta', 'Facebook &amp; Instagram ads'], ['Scaled', 'Profitable, repeatable spend']],
        'https://www.baileysblossoms.com'],
    ['moment', '#5B2EFF', '#FFFFFF', 'moment', '<span class="wbadge wiggle" style="background:#FF4F9A">★ SHARK TANK</span>',
        'WELLNESS · FUNCTIONAL BEVERAGES', 'Moment — growth for a Shark Tank–featured wellness brand',
        '<strong>Moment</strong> makes functional, meditation-inspired drinks and has been featured on <em>Shark Tank</em>. We support the brand across three fronts — sharpening the branding, growing organic visibility through SEO, and running paid ads — so a standout product reaches the people looking for it.',
        [['SEO', 'Organic search growth'], ['Brand', 'Positioning &amp; identity'], ['Ads', 'Paid acquisition']],
        'https://drinkmoment.com'],
    ['haliburton', '#3DEBB0', '#0E0B1F', 'Haliburton<br>Forest', '<span class="wbadge tilt" style="background:#FFFFFF">BOOKING SYSTEM</span>',
        'TOURISM · WEB &amp; BOOKING', 'Haliburton Forest — a 100,000-acre destination, online',
        "<strong>Haliburton Forest &amp; Wild Life Reserve</strong> is one of Ontario's largest outdoor adventure destinations — 100,000 acres and 100 lakes. We designed and developed their website and built the booking system that lets visitors reserve stays and activities right through the year.",
        [['Web', 'Full website, designed &amp; built'], ['Booking', 'Custom reservation system'], ['4-season', 'Stays &amp; activities online']],
        'https://www.haliburtonforest.com'],
];
?>
<section class="sec" id="cases">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">CASE STUDIES</span>
        <h2 class="h2">The work, and the numbers behind it.</h2>
      </div>
      <p class="sec-aside">Deep-dives into how we solve real problems for real brands — from building a store to being found across search and AI.</p>
    </div>

    <?php foreach ($cases as [$id, $bg, $fg, $word, $badges, $label, $title, $story, $metrics, $site]) : ?>
    <article class="case reveal" id="case-<?php echo esc_attr($id); ?>">
      <div class="case-panel" style="background:<?php echo esc_attr($bg); ?>"><?php echo $badges; ?><span class="work-word" style="color:<?php echo esc_attr($fg); ?>"><?php echo $word; ?></span></div>
      <div class="case-body">
        <span class="label"><?php echo $label; ?></span>
        <h3><?php echo esc_html($title); ?></h3>
        <p><?php echo $story; ?></p>
        <div class="metrics">
          <?php foreach ($metrics as [$v, $l]) : ?>
          <div class="metric"><span class="metric-v"><?php echo esc_html($v); ?></span><span class="metric-l"><?php echo $l; ?></span></div>
          <?php endforeach; ?>
        </div>
        <div class="btn-row"><a href="<?php echo esc_url($site); ?>" target="_blank" rel="noopener" class="btn btn-white">Visit <?php echo esc_html(preg_replace('#^https?://(www\.)?#', '', $site)); ?> ↗</a></div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>
