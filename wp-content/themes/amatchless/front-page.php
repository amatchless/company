<?php get_header(); ?>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="blob hero-blob-a" aria-hidden="true"></div>
  <div class="blob hero-blob-b hide-sm" aria-hidden="true"></div>
  <svg class="float hide-sm hero-star" aria-hidden="true" width="90" height="90" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FF4F9A"/></svg>
  <svg class="float2 hide-sm hero-wave" aria-hidden="true" width="120" height="60" viewBox="0 0 120 60"><path d="M4 40 Q 20 4 36 30 T 68 30 T 100 30 T 116 20" fill="none" stroke="#5B2EFF" stroke-width="8" stroke-linecap="round"/></svg>

  <div class="hero-in">
    <div class="pill-dark pop"><span class="pulse-dot" aria-hidden="true"></span>SOFTWARE × AI × MARKETING</div>

    <h1 class="hero-title">
      <span class="rise d1">Run</span>
      <span class="rise d2 hero-leaner">leaner.</span><br>
      <span class="rise d3">Grow</span>
      <span class="rise d4 hero-faster">faster.<svg aria-hidden="true" viewBox="0 0 400 40" preserveAspectRatio="none"><path class="draw" d="M4 30 C 80 6, 160 6, 220 22 S 340 36, 396 10" fill="none" stroke="#0E0B1F" stroke-width="7" stroke-linecap="round"/></svg></span>
    </h1>

    <div class="hero-row">
      <div class="hero-copy rise d5">
        <p class="hero-lede">One partner for software, AI and marketing. We start by understanding your business and its pain points, then build what makes it efficient — and market it to grow.</p>
        <div class="btn-row">
          <a class="btn btn-pink" href="<?php echo esc_url(amatchless_anchor('book')); ?>">Book a discovery call <span aria-hidden="true">↗</span></a>
          <a class="btn btn-white" href="#work">See our work →</a>
        </div>
      </div>

      <div class="hero-seal pop d6" aria-hidden="true">
        <svg class="spin" viewBox="0 0 200 200" width="150" height="150">
          <defs><path id="amxCircle" d="M100,100 m-78,0 a78,78 0 1,1 156,0 a78,78 0 1,1 -156,0"/></defs>
          <circle cx="100" cy="100" r="99" fill="#0E0B1F"/>
          <text font-family="DM Sans, sans-serif" font-weight="700" font-size="15" letter-spacing="3.4" fill="#FFFFFF"><textPath href="#amxCircle">BUILT TO PERFORM ✦ 4× ROAS ✦ SHARK TANK BRANDS ✦</textPath></text>
        </svg>
        <span class="hero-seal-core">4×</span>
      </div>
    </div>

    <p class="hero-proof rise d6">Two Shark Tank–featured brands · a ₹100 Cr company · a creator with 575K followers · 4× return on ad spend</p>
  </div>
</section>

<!-- ============ MARQUEE ============ -->
<?php
$clients  = ['ISOLA', 'ALEUCO', "BAILEY'S BLOSSOMS", 'MOMENT', 'HALIBURTON FOREST'];
$sparks   = ['#FFE14D', '#FF4F9A', '#3DEBB0'];
$services = ['CUSTOM SOFTWARE', 'AI & AUTOMATION', 'SEO', 'META & GOOGLE ADS', 'INFLUENCER MARKETING', 'BRANDING'];
// Each track holds two identical runs and slides by exactly one; the second run is hidden from screen readers.
?>
<section class="ticker" id="clients" aria-label="Clients and services">
  <div class="ticker-dark">
    <div class="track">
      <?php for ($run = 0; $run < 2; $run++) : ?>
      <div class="track-run"<?php echo $run ? ' aria-hidden="true"' : ''; ?>>
        <?php foreach ($clients as $i => $c) : ?>
        <span><?php echo esc_html($c); ?></span><span aria-hidden="true" style="color:<?php echo esc_attr($sparks[$i % 3]); ?>">✦</span>
        <?php endforeach; ?>
      </div>
      <?php endfor; ?>
    </div>
  </div>
  <div class="ticker-pink">
    <div class="track rev">
      <?php for ($run = 0; $run < 2; $run++) : ?>
      <div class="track-run"<?php echo $run ? ' aria-hidden="true"' : ''; ?>>
        <?php foreach ($services as $s) : ?>
        <span><?php echo esc_html($s); ?></span><span aria-hidden="true">●</span>
        <?php endforeach; ?>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ============ PROBLEM → FIX ============ -->
<section class="sec" id="pain">
  <div class="sec-in">
    <div class="sec-split reveal">
      <h2 class="h2">Most agencies sell you a service. We start with <span class="mark-yellow">your business.</span></h2>
      <p class="sec-aside">We dig into how you operate and where it hurts — then recommend the fix and build it ourselves. One team, one plan, nothing lost between vendors.</p>
    </div>
    <div class="pain-grid">
      <?php
      $pains = [
          ['Leads slip through the cracks',        'Automated capture and follow-up'],
          ['Too much manual, repetitive work',     'Process automation and AI'],
          ["Tools that don't talk to each other",  'Custom software that joins them up'],
          ["Customers can't find us online",       'SEO and content marketing'],
          ["Ad spend that doesn't pay back",       'Performance campaigns built for ROAS'],
          ['Our brand has no reach',               'Influencer and social marketing'],
      ];
      foreach ($pains as [$pain, $fix]) : ?>
      <div class="pain reveal">
        <span class="pain-label">PAIN</span>
        <p class="pain-text"><?php echo esc_html($pain); ?></p>
        <p class="pain-fix">→ <?php echo esc_html($fix); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_template_part('template-parts/section', 'services'); ?>

<?php get_template_part('template-parts/section', 'process'); ?>

<?php get_template_part('template-parts/section', 'work'); ?>

<?php get_template_part('template-parts/section', 'stats'); ?>

<?php get_template_part('template-parts/section', 'testimonials'); ?>

<?php get_template_part('template-parts/section', 'blog'); ?>

<?php get_template_part('template-parts/section', 'contact'); ?>

<?php get_footer(); ?>
